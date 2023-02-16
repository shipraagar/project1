@php
    $prefix = get_static_option('tenant_default_theme');
    $suffix = 'theme_'.$prefix;
@endphp

<style>
    @if($prefix == 'donation')
    :root {
        --main-color-one: {{get_static_option($prefix.'_main_color_one','#14BA85')}};
        --main-color-one-rgb: {{get_static_option($prefix.'_main_color_one_rgb','20, 186, 133;')}};
        --main-color-two: {{get_static_option($prefix.'_main_color_two','#524EB7')}};
        --main-color-two-rba: {{get_static_option($prefix.'_main_color_two_rba','82, 78, 183')}};
        --heading-color: {{get_static_option($prefix.'_heading_color','#333333')}};
        --heading-color-tow: {{get_static_option($prefix.'_heading_color_two','#586178')}};
        --heading-color-rgb: {{get_static_option($prefix.'_heading_color_rb','51, 51, 51')}};
        --secondary-color: {{get_static_option($prefix.'_secondary_color','#FBA260')}};
        --bg-light-one: {{get_static_option($prefix.'_bg_light_one','#F5F9FE')}};
        --bg-light-two: {{get_static_option($prefix.'_bg_light_two','#FEF8F3')}};
        --bg-dark-one: {{get_static_option($prefix.'_bg_dark_one','#040A1B')}};
        --bg-dark-two: {{get_static_option($prefix.'_bg_dark_two','#22253F')}};
        --paragraph-color: {{get_static_option($prefix.'_paragraph_color','#9A9C9F')}};
        --paragraph-color-two: {{get_static_option($prefix.'_paragraph_color_two','#475467')}};
        --paragraph-color-three: {{get_static_option($prefix.'_paragraph_color_three','#D0D5DD')}};
        --paragraph-color-four: {{get_static_option($prefix.'_paragraph_color_four','#344054')}};

        @if(empty(get_static_option('custom_font')))
        --heading-font: {{get_static_option('heading_font_family_'.$suffix,'sans-serif')}} ;
        --body-font: {{get_static_option('body_font_family_'.$suffix,'sans-serif')}};
         font-family: var(--body-font);
        @endif
    }
    @endif

    @if($prefix == 'event')

    :root {
        --main-color-one: {{get_static_option($prefix.'_main_color_one','#FF5229')}};
        --main-color-one-rgb: {{get_static_option($prefix.'_main_color_one_rgb','255, 82, 41')}};
        --main-color-two: {{get_static_option($prefix.'_main_color_two','#524EB7')}};
        --main-color-two-rba: {{get_static_option($prefix.'_main_color_two_rba','82, 78, 183')}};
        --heading-color: {{get_static_option($prefix.'_heading_color','#28272C')}};
        --heading-color-rgb:{{get_static_option($prefix.'_heading_color_rgb','73, 77, 87')}};
        --btn-color-one: {{get_static_option($prefix.'_btn_color_one','#FF5229')}};
        --btn-color-two: {{get_static_option($prefix.'_btn_color_two','#FF5229')}};
        --heading-color-tow: {{get_static_option($prefix.'_heading_color_two','#494D57')}};
        --heading-color-rgb: {{get_static_option($prefix.'_heading_color_rgb','73, 77, 87')}};
        --bg-light-one:{{get_static_option($prefix.'_bg_light_one','#F5F9FE')}};
        --bg-light-two: {{get_static_option($prefix.'_bg_light_two','#FEF8F3')}};
        --bg-dark-one: {{get_static_option($prefix.'_bg_dark_one','#040A1B')}};
        --bg-dark-two: {{get_static_option($prefix.'_bg_dark_two','#22253F')}};
        --paragraph-color: {{get_static_option($prefix.'_paragraph_color','#919191')}};
        --paragraph-color-two: {{get_static_option($prefix.'_paragraph_color_two','#D0D5DD')}};
        --paragraph-color-three: {{get_static_option($prefix.'_paragraph_color_three','#D0D5DD')}};
        --paragraph-color-four: {{get_static_option($prefix.'_paragraph_color_four','#D0D5DD')}};

        @if(empty(get_static_option('custom_font')))
           --heading-font: {{get_static_option('heading_font_family_'.$suffix,'sans-serif')}};
           --body-font: {{get_static_option('body_font_family_'.$suffix,'sans-serif')}};
           --font-family: var(--body-font);
        @endif
    }
    @endif


   @if($prefix == 'job-find')
       @php
            $suffix = 'job';
       @endphp
    :root {
      --main-color-one: {{get_static_option($suffix.'_main_color_one','#2C62F6')}};
      --main-color-one-rgb: {{get_static_option($suffix.'_main_color_one_rgb','44, 98, 246')}};
      --main-color-two:{{get_static_option($suffix.'_main_color_two','#FF8339')}};
      --main-color-two-rba: {{get_static_option($suffix.'_main_color_two_rba','255, 131, 57')}};
      --heading-color: {{get_static_option($suffix.'_heading_color','#12244C')}};
      --heading-color-rgb:{{get_static_option($suffix.'_heading_color_rgb','18, 36, 76')}};
      --heading-color-tow: {{get_static_option($suffix.'_heading_color_two','#07061A')}};
      --btn-color-one: {{get_static_option($suffix.'_btn_color_one','#2C62F6')}};
      --btn-color-two: {{get_static_option($suffix.'_btn_color_two','#FF5229')}};
      --sectionBg-one: {{get_static_option($suffix.'_section_bg_one','#F9F9F9')}};
      --scrollbar-bg:{{get_static_option($suffix.'_scroll_bar_bg','#F0F0F0')}};
      --scrollbar-color:{{get_static_option($suffix.'_scroll_bar_color','#c5c5c5')}};
      --paragraph-color: {{get_static_option($suffix.'_paragraph_color','#17171')}};
      --paragraph-color-two: {{get_static_option($suffix.'_paragraph_color_two','#475467')}};
         @php
             $suffix = 'theme_job';
         @endphp
         @if(empty(get_static_option('custom_font')))
            --heading-font: {{get_static_option('heading_font_family_'.$suffix,'sans-serif')}};
            --body-font: {{get_static_option('body_font_family_'.$suffix,'sans-serif')}};
              font-size: 16px;
              font-weight: 400;
              font-family: var(--body-font);
        @endif
    }
    @endif

   @if($prefix == 'support-ticketing')
       @php
        $suffix = 'support_ticket';
       @endphp
    :root {
      --main-color-one: {{get_static_option($suffix.'_main_color_one','#F7EA78')}};
      --main-color-one-rgb: {{get_static_option($suffix.'_main_color_one_rgb','247, 234, 120')}};
      --main-color-two: {{get_static_option($suffix.'_main_color_two','#B4E0C5')}};
      --main-color-two-rba: {{get_static_option($suffix.'_main_color_two_rba','180, 224, 197')}};
      --heading-color: {{get_static_option($suffix.'_heading_color','#030403')}};
      --heading-color-rgb:{{get_static_option($suffix.'_heading_color_rgb','3, 4, 3')}};
      --heading-color-tow: {{get_static_option($suffix.'_heading_color_two','#353836')}};
      --btn-color-one: {{get_static_option($suffix.'_btn_color_one','#F7EA78')}};
      --btn-color-two:{{get_static_option($suffix.'_btn_color_two','#B4E0C5')}};
      --sectionBg-one:{{get_static_option($suffix.'_section_bg_one','#B4E0C5')}};
      --scrollbar-bg:{{get_static_option($suffix.'_scroll_bar_bg','#F0F0F0')}};
      --scrollbar-color:{{get_static_option($suffix.'_scroll_bar_color','#c5c5c5')}};
      --paragraph-color:{{get_static_option($suffix.'_paragraph_color','#72787B')}};
      --paragraph-color-two: {{get_static_option($suffix.'_paragraph_color_two','#475467')}};
        @php
            $suffix = 'theme_support_ticket';
        @endphp
             @if(empty(get_static_option('custom_font')))
             --heading-font: {{get_static_option('heading_font_family_'.$suffix,'sans-serif')}};
              --body-font: {{get_static_option('body_font_family_'.$suffix,'sans-serif')}};
              font-size: 16px;
              font-weight: 400;
              font-family: var(--body-font);
        @endif
    }
    @endif

   @if($prefix == 'article-listing')

        @php
            $suffix = 'knowledgebase';
        @endphp

    :root {
      --main-color-one: {{get_static_option($suffix.'_main_color_one','#5459E8')}};
      --main-color-one-rgb: {{get_static_option($suffix.'_main_color_one_rgb','84, 89, 232')}};
      --main-color-two:{{get_static_option($suffix.'_main_color_two','#FF8339')}};
      --main-color-two-rba: {{get_static_option($suffix.'_main_color_two_rba','255, 131, 57')}};
      --heading-color:{{get_static_option($suffix.'_heading_color','#12244C')}};
      --heading-color-rgb:{{get_static_option($suffix.'_heading_color_rgb','18, 36, 76')}};
      --heading-color-tow:{{get_static_option($suffix.'_heading_color_two','#07061A')}};
      --btn-color-one: {{get_static_option($suffix.'_btn_color_one','##C62F6')}};
      --btn-color-two:{{get_static_option($suffix.'_btn_color_two','#FF5229')}};
      --sectionBg-one:{{get_static_option($suffix.'_section_bg_one','#5459E8')}};
      --sectionBg-two:{{get_static_option($suffix.'_section_bg_two','#F9F9F9')}};
      --scrollbar-bg:{{get_static_option($suffix.'_scroll_bar_bg','#F0F0F0')}};
      --scrollbar-color:{{get_static_option($suffix.'_scroll_bar_color','#c5c5c5')}};
      --paragraph-color: {{get_static_option($suffix.'_paragraph_color','#717171')}};
      --paragraph-color-two: {{get_static_option($suffix.'_paragraph_color_two','#475467')}};

  @php
    $suffix = 'theme_knowledgebase';
 @endphp
     @if(empty(get_static_option('custom_font')))
         --heading-font: {{get_static_option('heading_font_family_'.$suffix,'sans-serif')}};
          --body-font: {{get_static_option('body_font_family_'.$suffix,'sans-serif')}};
          font-size: 16px;
          font-weight: 400;
          font-family: var(--body-font);
      @endif
    }
    @endif

    @if($prefix == 'eCommerce')
        @php
           $suffix = 'ecommerce';
        @endphp
    :root {
      --main-color-one: {{get_static_option($suffix.'_main_color_one','#FF7465')}};
      --main-color-one-rgb:{{get_static_option($suffix.'_main_color_one_rgb','255, 116, 101')}};
      --main-color-two:{{get_static_option($suffix.'_main_color_two','#FF8339')}};
      --main-color-two-rba: {{get_static_option($suffix.'_main_color_two_rba','255, 131, 57')}};
      --heading-color: {{get_static_option($suffix.'_heading_color','#12244C')}};
      --heading-color-rgb:{{get_static_option($suffix.'_heading_color_rgb','81, 96, 114')}};
      --btn-color-one: {{get_static_option($suffix.'_btn_color_one','#FF7465')}};
      --btn-color-two: {{get_static_option($suffix.'_btn_color_two','#FF5229')}};
      --heading-color-tow: {{get_static_option($suffix.'_heading_color_two','#516072')}};
      --scrollbar-bg:{{get_static_option($suffix.'_scroll_bar_bg','#F0F0F0')}};
      --scrollbar-color:{{get_static_option($suffix.'_scroll_bar_color','#c5c5c5')}};
      --bg-light-one: {{get_static_option($suffix.'_bg_light_one','#F5F9FE')}};
      --bg-light-two: {{get_static_option($suffix.'_bg_light_two','#FEF8F3')}};
      --bg-dark-one: {{get_static_option($suffix.'_bg_dark_one','#040A1B')}};
      --bg-dark-two: {{get_static_option($suffix.'_bg_dark_two','#22253F')}};
      --paragraph-color: {{get_static_option($suffix.'_paragraph_color','#919191')}};
      --paragraph-color-two:{{get_static_option($suffix.'_paragraph_color_two','#475467')}};
      --paragraph-color-three: {{get_static_option($suffix.'_paragraph_color_three','#D0D5DD')}};
      --paragraph-color-four: {{get_static_option($suffix.'_paragraph_color_four','#344054')}};
      --stock-color: {{get_static_option($suffix.'_stock_color','#5AB27E')}};


      @php
         $suffix = 'theme_eCommerce';
      @endphp
       @if(empty(get_static_option('custom_font')))
          --heading-font: {{get_static_option('heading_font_family_'.$suffix,'sans-serif')}} !important;
           --body-font: {{get_static_option('body_font_family_'.$suffix,'sans-serif')}};
           font-size: 16px;
           font-weight: 400;
           font-family: var(--body-font);
        @endif
    }
    @endif


    @if($prefix == 'agency')

    :root {
        --main-color-one: {{get_static_option($prefix.'_main_color_one','#ffd338')}};
        --main-color-one-rgb:{{get_static_option($prefix.'_main_color_one_rgb','255, 211, 56')}};
        --agency-section-bg:{{get_static_option($prefix.'_agency_section_bg','#FFFCF4')}};
        --agency-section-bg-2:{{get_static_option($prefix.'_agency_section_bg_2','#6368E5')}};
        --agency-section-bg-3:{{get_static_option($prefix.'_agency_section_bg_3','#141414')}};
        --heading-color: {{get_static_option($prefix.'_heading_color','#1D2635')}};
        --heading-body-color:{{get_static_option($prefix.'_body_color','#777D86')}};
        --light-color: {{get_static_option($prefix.'_light_color','#777D86')}};
        --review-color: {{get_static_option($prefix.'_review_color','#FABE50')}};

        @if(empty(get_static_option('custom_font')))
        --heading-font: {{get_static_option('heading_font_family_'.$suffix,'sans-serif')}};
        --body-font: {{get_static_option('body_font_family_'.$suffix,'sans-serif')}};
          font-size: 16px;
          font-weight: 400;
          font-family: var(--body-font) !important;
        @endif
    }
    @endif


    @if($prefix == 'newspaper')

    :root {
        --main-color-one: {{get_static_option($prefix.'_main_color_one','#f65050')}};
        --main-color-one-rgb:{{get_static_option($prefix.'_main_color_one_rgb','246, 80, 80')}};
        --secondary-color:{{get_static_option($prefix.'_secondary_color','#FFD203')}};
        --secondary-color-rgb:{{get_static_option($prefix.'_secondary_color_rgb','255, 210, 3')}};
        --newspaper-section-bg:{{get_static_option($prefix.'_newspaper_section_bg','#141414')}};
        --newspaper-section-bg-2:{{get_static_option($prefix.'_newspaper_section_bg_2','#F9F9F9')}};
        --border-color: {{get_static_option($prefix.'_border_color','#e9e9e9')}};
        --border-color-2: {{get_static_option($prefix.'_border_color_2','#f3f3f3')}};
        --heading-color: {{get_static_option($prefix.'_heading_color','#1D2635')}};
        --body-color:{{get_static_option($prefix.'_body_color','#777D86')}};
        --light-color: {{get_static_option($prefix.'_light_color','#777D86')}};
        --review-color: {{get_static_option($prefix.'_review_color','#FABE50')}};

     @if(empty(get_static_option('custom_font')))
        --heading-font: {{get_static_option('heading_font_family_'.$suffix,'Inter')}};
        --body-font: {{get_static_option('body_font_family_'.$suffix,'Inter')}};
        font-size: 16px;
        font-weight: 400;
        font-family: var(--body-font) !important;
    @endif
}
    @endif

  @if($prefix == 'construction')

    :root {
        --main-color-one: {{get_static_option($prefix.'_main_color_one','#fe762a')}};
        --main-color-one-rgb:{{get_static_option($prefix.'_main_color_one_rgb','254, 118, 42')}};
        --main-color-two:{{get_static_option($prefix.'_main_color_two','#ff6b2c')}};
        --main-color-two-rgb:{{get_static_option($prefix.'_main_color_two_rgb','255, 107, 44')}};
        --construction-section-bg:{{get_static_option($prefix.'_section_bg','#FFFDF6')}};
        --construction-section-bg-2:{{get_static_option($prefix.'_section_bg_2','#F9F9F9')}};
        --construction-section-bg-3: {{get_static_option($prefix.'_section_bg_3','#141414')}};
        --white: {{get_static_option($prefix.'_white','#ffffff')}};
        --white-rgb: {{get_static_option($prefix.'_white_rgb','255, 255, 255')}};
        --black: {{get_static_option($prefix.'_black','#000')}};
        --black-rgb:{{get_static_option($prefix.'_black_rgb','0, 0, 0')}};
        --border-color:{{get_static_option($prefix.'_border_color','#ebebeb')}};
        --border-color-two:{{get_static_option($prefix.'_border_color_two','#eff0f1')}};
        --heading-color:{{get_static_option($prefix.'_heading_color','#1D2635')}};
        --body-color:{{get_static_option($prefix.'_body_color','#8a8f96')}};
        --paragraph-color: {{get_static_option($prefix.'_paragraph_color','#777D86')}};
        --light-color: {{get_static_option($prefix.'_light_color','#777D86')}};
        --review-color: {{get_static_option($prefix.'_review_color','#FABE50')}};

        @if(empty(get_static_option('custom_font')))
        --heading-font: {{get_static_option('heading_font_family_'.$suffix,'Inter')}};
        --body-font: {{get_static_option('body_font_family_'.$suffix,'Inter')}};
        @endif
}
    @endif


    @if($prefix == 'consultancy')

    :root {
        --main-color-one: {{get_static_option($prefix.'_main_color_one','#3b50e0')}};
        --main-color-one-rgb:{{get_static_option($prefix.'_main_color_one_rgb','59, 80, 22')}};
        --main-color-two:{{get_static_option($prefix.'_main_color_two','#ff6b2c')}};
        --main-color-two-rgb:{{get_static_option($prefix.'_main_color_two_rgb','255, 107, 44')}};
        --consulting-section-bg:{{get_static_option($prefix.'_section_bg','#FFFDF6')}};
        --consulting-section-bg-2:{{get_static_option($prefix.'_section_bg_2','#F9F9F9')}};
        --consulting-section-bg-3: {{get_static_option($prefix.'_section_bg_3','#141414')}};
        --white: {{get_static_option($prefix.'_white','#ffffff')}};
        --white-rgb: {{get_static_option($prefix.'_white_rgb','255, 255, 255')}};
        --black: {{get_static_option($prefix.'_black','#000')}};
        --black-rgb:{{get_static_option($prefix.'_black_rgb','0, 0, 0')}};
        --border-color:{{get_static_option($prefix.'_border_color','#ebebeb')}};
        --border-color-two:{{get_static_option($prefix.'_border_color_two','#eff0f1')}};
        --heading-color:{{get_static_option($prefix.'_heading_color','#1D2635')}};
        --body-color:{{get_static_option($prefix.'_body_color','#8a8f96')}};
        --paragraph-color: {{get_static_option($prefix.'_paragraph_color','#666')}};
        --light-color: {{get_static_option($prefix.'_light_color','#8a8f96')}};
        --review-color: {{get_static_option($prefix.'_review_color','#FABE50')}};

        @if(empty(get_static_option('custom_font')))
        --heading-font: {{get_static_option('heading_font_family_'.$suffix,'Inter')}};
        --body-font: {{get_static_option('body_font_family_'.$suffix,'Inter')}};
    @endif
}
    @endif




</style>
