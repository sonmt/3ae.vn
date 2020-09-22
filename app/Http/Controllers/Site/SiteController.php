<?php
namespace App\Http\Controllers\Site;

use App\Entity\Information;
use App\Entity\Input;
use App\Entity\Language;
use App\Entity\Menu;
use App\Entity\MenuElement;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Post;
use App\Entity\TypeInformation;
use App\Entity\TypeInput;
use App\Http\Controllers\Controller;
use App\Ultility\Facebook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:02 AM
 */
class SiteController extends Controller
{
    public $languageCurrent;
    public $colorLogo;
    public $logoSite;
    
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->languageCurrent = session('languageCurrent', 'vn');
            $logo = Post::where('slug', '3ae')->first();
            $inputs = Input::where('post_id', $logo->post_id)->get();
            foreach ($inputs as $input) {
                $logo[$input->type_input_slug] = $input->content;
            }
            $this->colorLogo = $logo['mau-sac-thuong-hieu'];
            $this->logoSite=  $logo->image;
            $fanpage = $logo['chen-fanpage-thuong-hieu'];

            $typeInformations = TypeInformation::orderBy('type_infor_id')->get();

            // get information
            $informations = Information::where('language', $this->languageCurrent)
                ->where('language', $this->languageCurrent)->get();
            $informationShow = array();
            foreach($typeInformations as $id => $typeInformation) {
                $typeInformations[$id]['information'] = '';
                foreach ($informations as $information) {
                    if ($information->slug_type_input == $typeInformation->slug) {
                        $informationShow[$typeInformation->slug] = $information->content;
                        break;
                    }
                }
            }

            $languages = Language::orderBy('language_id', 'asc')->get();
            $urlLoginFace = $this->getUrlLoginFacebook();

            $language = Language::where('acronym', $this->languageCurrent)->first();
            // lọc bỏ những trường mà ko sử dụng trong post
            $typeInputDatabase = TypeInput::orderBy('type_input_id')
                ->where('post_used', 'like', '%language%')
                ->orWhere('post_used', 'like', 'language%')
                ->get();

            $typeInputs = array();
            foreach($typeInputDatabase as $typeInput) {
                $typeInputs[] = $typeInput;
                $language[$typeInput->slug] = Input::getPostMeta($typeInput->slug, $language->language_id);
            }

            $activeMenu = '';
            foreach (Menu::showWithLocation('menu-top') as $menu) {
                foreach (MenuElement::showMenuElement($menu->slug) as $id => $menuElement) {
                    if ($id == 0) {
                        $activeMenu = $menuElement->url;
                    }

                }
            }

            $nameRoute = '/';
            $mainId = '0';
            $arrayRoute = '';
            
            view()->share([
                'information' => $informationShow,
                'urlLoginFace' => $urlLoginFace,
                'languageCurrent' => $this->languageCurrent,
                'languages' => $languages,
                'languageSetup' => $language,
                'colorLogo' => $this->colorLogo,
                'logoSite' => $this->logoSite,
                'activeMenu' => $activeMenu,
                'fanpage' => $fanpage,
                'nameRoute' => $nameRoute,
                'mainId' => $mainId,
                'arrayRoute' => $arrayRoute
            ]);
            
            return $next($request);
        });



    }

    private function getUrlLoginFacebook () {
        $app = new Facebook();

        $fb = new \Facebook\Facebook([
            'app_id' => $app->getAppId(),
            'app_secret' => $app->getAppSecret(),
            'default_graph_version' => $app->getDefaultGraphVersion()
        ]);

        $helper = $fb->getRedirectLoginHelper();


        $permissions = []; // optional
        $loginUrl = $helper->getLoginUrl(URL::to('/').'/cblogin', $permissions);

        return $loginUrl;
    }
}
