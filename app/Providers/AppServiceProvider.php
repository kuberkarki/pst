<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\SF_settings;
use App\e_com_category__c;
use Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $setting=SF_settings::where('name','eXpress main settings')->first();
            //config()->set('settings', $setting);
            Config::set('mail.host', $setting->attigo__smtp__c);
            //Config::set('mail.port', $setting->sm_port);
            //Congig::set('mail.from' => ['address' => $setting->smtp__c, 'name' => $setting->smtp__c]);
            Config::set('mail.username', $setting->attigo__smtp_username__c);
            Config::set('mail.password', $setting->attigo__smtp_password__c);

        view()->composer('emails.layouts.thebox', function($view)
        {
            $setting=SF_settings::where('name','eXpress main settings')->first();
            $view->with('settings', $setting);
        });
        
        view()->composer('layouts.thebox', function($view)
        {
           $schemas=explode(',','brick-red,bright-turquoise,cerise,de-york,denim,green-smoke,hipple-blue,horizon,leather,mandy,salem,scarlet,shamrock,studio,turkish-rose');
            $setting=SF_settings::where('name','eXpress main settings')->first();

            $attigo__home_top_links__c=explode(';',$setting->attigo__home_top_links__c);
            $main_menu=array();
            for($i=0;$i<count($attigo__home_top_links__c);$i=$i+2){
                $main_menu[$i+2]=$attigo__home_top_links__c[$i];
            }


            $attigo__footer_links__c=explode(';',$setting->attigo__footer_links__c);
            $footer_menu=array();
            for($i=0;$i<count($attigo__footer_links__c);$i=$i+2){
                $footer_menu[$i+2]=$attigo__footer_links__c[$i];
            }

            $footer_image_1=$footer_image_2=array();

            $footer_image_1=explode(';',$setting->attigo__footer_image_1_url__c);
            $footer_image_2=explode(';',$setting->attigo__footer_image_2_url__c);


            $main_categories=e_com_category__c::where('attigo__active__c','1')->where('attigo__include_in_main_menue__c','1')->orderby('id')->get();



            if($setting->attigo__css_color_scheme__c && $setting->attigo__css_color_scheme__c>0 && $setting->attigo__css_color_scheme__c<=15)
                $view->with('css', $setting->attigo__link_to_custom_css_file__c)->with('schema',$schemas[$setting->attigo__css_color_scheme__c-1])->with('logo',$setting->attigo__storefront_logo_link__c)->with('slogan',$setting->attigo__default_welcome_msg__c)->with('main_menu',$main_menu)->with('main_categories',$main_categories)->with('footer_menu',$footer_menu)->with('footer_color_1',$setting->attigo__footer_color_1__c)->with('footer_color_2',$setting->attigo__footer_color_2__c)->with('footer_image_1',$footer_image_1)->with('footer_image_2',$footer_image_2)->with('footer_text',$setting->attigo__footer_text__c)->with('settings',$setting);
            else
                $view->with('css', $setting->attigo__link_to_custom_css_file__c)->with('logo',$setting->attigo__storefront_logo_link__c)->with('slogan',$setting->attigo__default_welcome_msg__c)->with('main_menu',$main_menu)->with('main_categories',$main_categories)->with('footer_menu',$footer_menu)->with('footer_color_1',$setting->attigo__footer_color_1__c)->with('footer_color_2',$setting->attigo__footer_color_2__c)->with('footer_image_1',$footer_image_1)->with('footer_image_2',$footer_image_2)->with('footer_text',$setting->attigo__footer_text__c)->with('settings',$setting);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
