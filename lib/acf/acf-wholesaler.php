<?php

add_action( 'acf/init', function () {

  global $current_user;
  wp_get_current_user(); // Make sure global $current_user is set, if not set it

  acf_add_local_field_group(array(
    'key' => 'group_5b5ec83fc69b8',
    'title' => 'Kontaktní údaje',
    'fields' => array(
      array(
        'key' => 'field_5bbdc26030686',
        'label' => 'Země',
        'name' => 'country',
        'type' => 'select',
        'instructions' => '',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'choices' => array(
          'cz' => 'Česká republika',
          'sk' => 'Slovensko',
        ),
        'default_value' => array(
          0 => 'cz',
        ),
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'return_format' => 'array',
        'ajax' => 0,
        'placeholder' => '',
      ),
      array(
        'key' => 'field_5b5ecaf4052fb',
        'label' => 'IČO',
        'name' => 'in',
        'type' => 'text',
        'instructions' => 'Např. „28935675“.',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_5b5ecc9d052fc',
        'label' => 'DIČ',
        'name' => 'tin',
        'type' => 'text',
        'instructions' => 'Např. „CZ28935675“.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_5b5ec9b4052f8',
        'label' => 'Ulice a č. p.',
        'name' => 'street',
        'type' => 'text',
        'instructions' => 'Např. "Dvořeckého 628/8"',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_5b5eca63052f9',
        'label' => 'Město',
        'name' => 'city',
        'type' => 'text',
        'instructions' => 'Např. "Praha 6"',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_5b5eca9d052fa',
        'label' => 'PSČ',
        'name' => 'zip',
        'type' => 'text',
        'instructions' => 'Např. „12300“.',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_5b5ed2ca0a22d',
        'label' => 'Kraj',
        'name' => 'region',
        'type' => 'select',
        'instructions' => '',
        'required' => 1,
        'conditional_logic' => array(
          array(
            array(
              'field' => 'field_5bbdc26030686',
              'operator' => '==',
              'value' => 'cz',
            ),
          ),
        ),
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'choices' => array(
          0 => 'Hlavní město Praha',
          1 => 'Jihočeský kraj',
          2 => 'Jihomoravský kraj',
          3 => 'Karlovarský kraj',
          4 => 'Kraj Vysočina',
          5 => 'Královéhradecký kraj',
          6 => 'Liberecký kraj',
          7 => 'Moravskoslezský kraj',
          8 => 'Olomoucký kraj',
          9 => 'Pardubický kraj',
          10 => 'Plzeňský kraj',
          11 => 'Středočeský kraj',
          12 => 'Ústecký kraj',
          13 => 'Zlínský kraj',
        ),
        'default_value' => array(
        ),
        'allow_null' => 1,
        'multiple' => 0,
        'ui' => 0,
        'return_format' => 'array',
        'ajax' => 0,
        'placeholder' => '',
      ),
      array(
        'key' => 'field_5bbdc19430685',
        'label' => 'Kraj',
        'name' => 'region',
        'type' => 'select',
        'instructions' => '',
        'required' => 1,
        'conditional_logic' => array(
          array(
            array(
              'field' => 'field_5bbdc26030686',
              'operator' => '==',
              'value' => 'sk',
            ),
          ),
        ),
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'choices' => array(
          14 => 'Bratislavský kraj',
          15 => 'Trnavský kraj',
          16 => 'Trenčínský kraj',
          17 => 'Nitranský kraj',
          18 => 'Žilinský kraj',
          19 => 'Banskobystrický kraj',
          20 => 'Prešovský kraj',
          21 => 'Košický kraj',
        ),
        'default_value' => array(
        ),
        'allow_null' => 1,
        'multiple' => 0,
        'ui' => 0,
        'return_format' => 'array',
        'ajax' => 0,
        'placeholder' => '',
      ),
      array(
        'key' => 'field_5b5eccbb052fd',
        'label' => 'Web',
        'name' => 'website',
        'type' => 'text',
        'instructions' => 'URL adresa vašeho webu. Např. „https://www.obchodiste.cz“',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_5b5ecd01052fe',
        'label' => 'Facebook',
        'name' => 'facebook',
        'type' => 'url',
        'instructions' => 'Adresa na váš případný Facebook profil. Např. „https://www.facebook.com/obchodiste/“',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
      ),
      array(
        'key' => 'field_5b5ecd0f052ff',
        'label' => 'Twitter',
        'name' => 'twitter',
        'type' => 'url',
        'instructions' => 'Adresa na váš případný Twitter profil. Např. „https://twitter.com/shoptet“.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
      ),
      array(
        'key' => 'field_5b854f2feaf16',
        'label' => 'Instagram',
        'name' => 'instagram',
        'type' => 'url',
        'instructions' => 'Adresa na váš případný Instagram profil. Např. „https://www.instagram.com/shoptet.cz“.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
      ),
      array(
        'key' => 'field_5b5ed8dcce814',
        'label' => 'Logo',
        'name' => 'logo',
        'type' => 'image',
        'instructions' => 'Doporučujeme nahrát logo o velikosti alespoň 600 x 315 px. Nejlépe však 1200 x 630 px a více.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'return_format' => 'array',
        'preview_size' => 'wholesaler-logo-thumb',
        'library' => 'uploadedTo',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => 2,
        'mime_types' => '',
      ),
      array(
        'key' => 'field_5b86c6c02b205',
        'label' => 'E-shop na Shoptetu',
        'name' => 'is_shoptet',
        'type' => 'true_false',
        'instructions' => 'Provozujete svůj e-shop na Shoptet řešení?',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'message' => 'Provozuji e-shop na Shoptetu',
        'default_value' => 0,
        'ui' => 0,
        'ui_on_text' => '',
        'ui_off_text' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'custom',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'left',
    'instruction_placement' => 'field',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
  ));


  acf_add_local_field_group(array(
    'key' => 'group_5d39e3967a178',
    'title' => 'Velkoobchod – hlavní',
    'fields' => array(
      array(
        'key' => 'field_5d39e3b8467ea',
        'label' => 'Název projektu',
        'name' => 'project_title',
        'type' => 'text',
        'instructions' => 'Zadejte název projektu, pod kterým vás znají zákazníci. Např. „Obchodiště“',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'custom',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'acf_after_title',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
  ));


  acf_add_local_field_group(array(
    'key' => 'group_5b5ed46570d96',
    'title' => 'Kontaktní osoba',
    'fields' => array(
      array(
        'key' => 'field_5b5ed477147d7',
        'label' => 'Jméno a příjmení',
        'name' => 'contact_full_name',
        'type' => 'text',
        'instructions' => 'Např. "Jan Novák"',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_5b5ed49d147d8',
        'label' => 'E-mail',
        'name' => 'contact_email',
        'type' => 'email',
        'instructions' => 'Např. "info@obchodiste.cz"',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
      ),
      array(
        'key' => 'field_5b5ed4d3147d9',
        'label' => 'Telefon',
        'name' => 'contact_tel',
        'type' => 'text',
        'instructions' => 'Např. "+420603123456"',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_5b5ed50b147da',
        'label' => 'Fotografie obchodního zástupce',
        'name' => 'contact_photo',
        'type' => 'image',
        'instructions' => 'Doporučujeme nahrát fotografii o velikosti alespoň 100 x 100 px a zároveň ne větší než 500 x 500 px.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'return_format' => 'array',
        'preview_size' => 'thumbnail',
        'library' => 'uploadedTo',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => 2,
        'mime_types' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'custom',
        ),
      ),
    ),
    'menu_order' => 1,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'left',
    'instruction_placement' => 'field',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
  ));


  acf_add_local_field_group(array(
    'key' => 'group_5b5ed585187a6',
    'title' => 'Podrobné informace',
    'fields' => array(
      array(
        'key' => 'field_5b5ed5a9ddd56',
        'label' => 'Hlavní kategorie',
        'name' => 'category',
        'type' => 'taxonomy',
        'instructions' => 'Zvolte si hlavní kategorii, do které spadá vaše firma.',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'taxonomy' => 'customtaxonomy',
        'field_type' => 'select',
        'allow_null' => 0,
        'add_term' => 0,
        'save_terms' => 0,
        'load_terms' => 0,
        'return_format' => 'object',
        'multiple' => 0,
      ),
      array(
        'key' => 'field_5bff0ff2793a9',
        'label' => 'Vedlejší kategorie 1',
        'name' => 'minor_category_1',
        'type' => 'taxonomy',
        'instructions' => 'Zvolte si případnou vedlejší kategorii, do které spadá vaše firma.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'taxonomy' => 'customtaxonomy',
        'field_type' => 'select',
        'allow_null' => 1,
        'add_term' => 0,
        'save_terms' => 0,
        'load_terms' => 0,
        'return_format' => 'object',
        'multiple' => 0,
      ),
      array(
        'key' => 'field_5bff1029793aa',
        'label' => 'Vedlejší kategorie 2',
        'name' => 'minor_category_2',
        'type' => 'taxonomy',
        'instructions' => 'Zvolte si případnou další vedlejší kategorii, do které spadá vaše firma.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'taxonomy' => 'customtaxonomy',
        'field_type' => 'select',
        'allow_null' => 1,
        'add_term' => 0,
        'save_terms' => 0,
        'load_terms' => 0,
        'return_format' => 'object',
        'multiple' => 0,
      ),
      array(
        'key' => 'field_5b5ed640ddd57',
        'label' => 'Krátce o naší nabídce',
        'name' => 'short_about',
        'type' => 'wysiwyg',
        'instructions' => 'V krátkosti popište jaké zboží prodejcům nabízíte, jeho historii a případnou výjimečnost.',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'tabs' => 'all',
        'toolbar' => 'full',
        'media_upload' => 0,
        'delay' => 0,
      ),
      array(
        'key' => 'field_5b5ed686ddd58',
        'label' => 'Co vám nabídneme?',
        'name' => 'services',
        'type' => 'checkbox',
        'instructions' => 'Vyberte si příznaky hlavních benefitů, které pro prodejce máte.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'choices' => array(
          'Shoptet XML feed' => 'Shoptet XML feed',
          'Nonstop podpora' => 'Nonstop podpora',
          'Dárky k větším objednávkám' => 'Dárky k větším objednávkám',
          'Dropshipping' => 'Dropshipping',
        ),
        'allow_custom' => 1,
        'save_custom' => 0,
        'default_value' => array(
        ),
        'layout' => 'horizontal',
        'toggle' => 0,
        'return_format' => 'value',
      ),
      array(
        'key' => 'field_5b5ed759ddd59',
        'label' => 'O naší firmě',
        'name' => 'about_company',
        'type' => 'wysiwyg',
        'instructions' => 'Představte potenciálním prodávajícím co nejlépe historii a zajímavosti o vaší firmě.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'tabs' => 'all',
        'toolbar' => 'full',
        'media_upload' => 0,
        'delay' => 0,
      ),
      array(
        'key' => 'field_5b5ed775ddd5a',
        'label' => 'O našich produktech',
        'name' => 'about_products',
        'type' => 'wysiwyg',
        'instructions' => 'Podrobněji se rozepište o specifikách produktů, které prodejcům nabízíte.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'tabs' => 'all',
        'toolbar' => 'full',
        'media_upload' => 0,
        'delay' => 0,
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'custom',
        ),
      ),
    ),
    'menu_order' => 2,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
  ));


  acf_add_local_field_group(array(
    'key' => 'group_5b5f030dd7ca1',
    'title' => 'Galerie a video',
    'fields' => array(
      array(
        'key' => 'field_5b5f0597506c8',
        'label' => 'Galerie',
        'name' => 'gallery',
        'type' => 'gallery',
        'instructions' => 'Aby si zájemci udělali lepší obrázek o tom co nabízíte, vložte zde pár prezentačních snímků vašich produktů.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'min' => '',
        'max' => '',
        'insert' => 'append',
        'library' => 'uploadedTo',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => 2,
        'mime_types' => '',
        'return_format' => 'array',
        'preview_size' => 'medium',
      ),
      array(
        'key' => 'field_5b5f05c8506c9',
        'label' => 'Video',
        'name' => 'video',
        'type' => 'oembed',
        'instructions' => 'Vložte video z YouTube nebo Vimeo obsahující informace o vašich produktech nebo firmě.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'width' => '',
        'height' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'custom',
        ),
      ),
    ),
    'menu_order' => 3,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
  ));

  if ( user_can( $current_user, 'administrator' ) ):
      
    acf_add_local_field_group(array(
      'key' => 'group_5f7d8d0ccba2c',
      'title' => 'Prémiový zápis',
      'fields' => array(
        array(
          'key' => 'field_5f7d8d129849b',
          'label' => 'Prémiový zápis',
          'name' => 'is_premium',
          'type' => 'true_false',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'message' => 'Aktivovat prémiový zápis dle data',
          'default_value' => 0,
          'ui' => 0,
          'ui_on_text' => '',
          'ui_off_text' => '',
        ),
        array(
          'key' => 'field_5f7d8e319849c',
          'label' => 'Prémiový zápis od',
          'name' => 'premium_date_from',
          'type' => 'date_picker',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'display_format' => 'F j, Y',
          'return_format' => 'Ymd',
          'first_day' => 1,
        ),
        array(
          'key' => 'field_5f7d8e6e9849d',
          'label' => 'Prémiový zápis do',
          'name' => 'premium_date_to',
          'type' => 'date_picker',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'display_format' => 'F j, Y',
          'return_format' => 'Ymd',
          'first_day' => 1,
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'custom',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => true,
      'description' => '',
    ));

  endif;

} );