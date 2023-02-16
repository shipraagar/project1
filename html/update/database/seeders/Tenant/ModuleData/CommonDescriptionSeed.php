<?php

namespace Database\Seeders\Tenant\ModuleData;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Page;
use App\Models\Testimonial;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogCategory;
use Modules\Donation\Entities\Donation;
use Modules\Donation\Entities\DonationActivity;
use Modules\Donation\Entities\DonationActivityCategory;
use Modules\Donation\Entities\DonationCategory;
use Modules\Event\Entities\Event;
use Modules\Event\Entities\EventCategory;
use Modules\Job\Entities\Job;
use Modules\Job\Entities\JobCategory;
use Modules\Knowledgebase\Entities\Knowledgebase;
use Modules\Knowledgebase\Entities\KnowledgebaseCategory;
use Modules\Portfolio\Entities\Portfolio;
use Modules\Portfolio\Entities\PortfolioCategory;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductShippingReturnPolicy;
use Modules\Service\Entities\Service;
use Modules\Service\Entities\ServiceCategory;

class CommonDescriptionSeed
{
    public static function execute()
    {
        //Main tables
        $models = [
             Job::where('status',1)->get(),
             Service::where('status',1)->get(),
             Donation::where('status',1)->get(),
             Portfolio::where('status',1)->get(),
             Knowledgebase::where('status',1)->get(),
             DonationActivity::where('status',1)->get(),
             Faq::where('status',1)->get(),
        ];

        foreach ($models as $table){
            foreach ($table as $item){
                $item->setTranslation('title','ar',self::title_arabic());
                $item->setTranslation('description','en_US',self::description_english());
                $item->setTranslation('description','ar',self::description_arabic());
                $item->save();
            }
        }

        //for Product
        $products = Product::all();
        foreach ($products as $item){
              $item->setTranslation('description','en_US',self::description_english());
              $item->setTranslation('description','ar',self::description_arabic());
              $item->setTranslation('summary','en_US',self::description_english());
              $item->setTranslation('summary','ar',self::description_arabic());
              $item->save();
        }

        //Product Shipping Return Policy
        $products = ProductShippingReturnPolicy::all();
        foreach ($products as $item){
            $item->setTranslation('shipping_return_description','en_US',self::description_english());
            $item->setTranslation('shipping_return_description','ar',self::description_arabic());
            $item->save();
        }

        //Main table categories
        $category_models = [
            DonationCategory::where('status',1)->get(),
            ServiceCategory::where('status',1)->get(),
            JobCategory::where('status',1)->get(),
            PortfolioCategory::where('status',1)->get(),
            KnowledgebaseCategory::where('status',1)->get(),
            DonationActivityCategory::where('status',1)->get(),
            FaqCategory::where('status',1)->get(),
            BlogCategory::where('status',1)->get(),
            EventCategory::where('status',1)->get(),
        ];

        foreach ($category_models as $table){
            foreach ($table as $item){
                $item->setTranslation('title','ar',self::title_arabic_category());
                $item->save();
            }
        }

        self::other_diff_name_tables();


    }


    private static function description_english() : string
    {
        $desc = 'We are very much greatful to you for your donation. Your little effort help us to change big community life I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally
        We are very much greatful to you for your donation. Your little effort help us to change big community life I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual . I must explain to you how all this mistaken idea of denouncing pleasure .
        We are very much greatful to you for your donation. Your little effort help us to change big community life I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual . I must explain to you how all this mistaken idea of denouncing pleasure .
        We are very much greatful to you for your donation. Your little effort help us to change big community life I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual . I must explain to you how all this mistaken idea of denouncing pleasure .
        We are very much greatful to you for your donation. Your little effort help us to change big community life I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual . I must explain to you how all this mistaken idea of denouncing pleasure ';

        return $desc;
    }

    private static function title_arabic() : string
    {
        $title = ' بعق للتنديد باللذة';

        return $title;
    }

    private static function title_arabic_category() : string
    {
        $title = ' باللذة';

        return $title;
    }

    private static function description_arabic() : string
    {
        $desc = 'نحن ممتنون جدًا لك على تبرعك. يساعدنا مجهودك الصغير في تغيير الحياة المجتمعية الكبيرة ، ويجب أن أشرح لك كيف ولدت كل هذه الفكرة الخاطئة المتمثلة في إدانة المتعة ومدح الألم ، وسأقدم لك وصفًا كاملاً للنظام ، وأشرح التعاليم الفعلية للمستكشف العظيم. الحقيقة ، صانع السعادة البشرية. لا أحد يرفض أو يكره أو يتجنب المتعة نفسها ، لأنها متعة ، ولكن لأن أولئك الذين لا يعرفون كيف يسعون وراء المتعة بعقلانية
        نحن ممتنون جدًا لك على تبرعك. يساعدنا مجهودك الصغير في تغيير الحياة المجتمعية الكبيرة ، ويجب أن أشرح لك كيف ولدت كل هذه الفكرة الخاطئة المتمثلة في إدانة المتعة ومدح الألم ، وسأقدم لك وصفًا كاملاً للنظام ، وأشرح لك حقيقة الأمر. يجب أن أشرح لك كيف كل هذه الفكرة الخاطئة للتنديد باللذة.
        نحن ممتنون جدًا لك على تبرعك. يساعدنا مجهودك الصغير في تغيير الحياة المجتمعية الكبيرة ، ويجب أن أشرح لك كيف ولدت كل هذه الفكرة الخاطئة المتمثلة في إدانة المتعة ومدح الألم ، وسأقدم لك وصفًا كاملاً للنظام ، وأشرح لك حقيقة الأمر. يجب أن أشرح لك كيف كل هذه الفكرة الخاطئة للتنديد باللذة.
        نحن ممتنون جدًا لك على تبرعك. يساعدنا مجهودك الصغير في تغيير الحياة المجتمعية الكبيرة ، ويجب أن أشرح لك كيف ولدت كل هذه الفكرة الخاطئة المتمثلة في إدانة المتعة ومدح الألم ، وسأقدم لك وصفًا كاملاً للنظام ، وأشرح لك حقيقة الأمر. يجب أن أشرح لك كيف كل هذه الفكرة الخاطئة للتنديد باللذة.
        نحن ممتنون جدًا لك على تبرعك. يساعدنا مجهودك الصغير في تغيير الحياة المجتمعية الكبيرة ، ويجب أن أشرح لك كيف ولدت كل هذه الفكرة الخاطئة المتمثلة في إدانة المتعة ومدح الألم ، وسأقدم لك وصفًا كاملاً للنظام ، وأشرح لك حقيقة الأمر. يجب أن أشرح لك كيف كل هذه الفكرة الخاطئة للتنديد باللذة
        ';

        return $desc;
    }


    private static function other_diff_name_tables()
    {
        $events = Event::where('status',1)->get();
        $blogs = Blog::where('status',1)->get();
        $pages = Page::where('status',1)->get();
        $testimonials = Testimonial::where('status',1)->get();

        foreach ($events as $item){
            $item->setTranslation('title','ar',self::title_arabic());
            $item->setTranslation('content','en_US',self::description_english());
            $item->setTranslation('content','ar',self::description_arabic());
            $item->save();
        }

        foreach ($blogs as $item){
            $item->setTranslation('title','ar',self::title_arabic());
            $item->setTranslation('blog_content','en_US',self::description_english());
            $item->setTranslation('blog_content','ar',self::description_arabic());
            $item->save();
        }

        foreach ($pages as $item){
            $item->setTranslation('title','ar',self::title_arabic());
            $item->save();
        }

        foreach ($testimonials as $item){
            $item->setTranslation('name','ar',self::title_arabic());
            $item->setTranslation('designation','ar',self::title_arabic());
            $item->setTranslation('description','ar',self::description_arabic());
            $item->setTranslation('company','ar',self::title_arabic());
            $item->save();
        }
    }

}
