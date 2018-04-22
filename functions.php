<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */
/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if (version_compare($GLOBALS['wp_version'], '4.7-alpha', '<')) {
    require get_template_directory() . '/inc/back-compat.php';
    return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
     * If you're building a theme based on Twenty Seventeen, use a find and replace
     * to change 'twentyseventeen' to the name of your theme in all the template files.
     */
    load_theme_textdomain('twentyseventeen');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    add_image_size('twentyseventeen-featured-image', 2000, 1200, true);

    add_image_size('twentyseventeen-thumbnail-avatar', 100, 100, true);

    // Set the default content width.
    $GLOBALS['content_width'] = 525;

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus(array(
        'top' => __('Top Menu', 'twentyseventeen'),
        'social' => __('Social Links Menu', 'twentyseventeen'),
    ));

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    /*
     * Enable support for Post Formats.
     *
     * See: https://codex.wordpress.org/Post_Formats
     */
    add_theme_support('post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
    ));

    // Add theme support for Custom Logo.
    add_theme_support('custom-logo', array(
        'width' => 250,
        'height' => 250,
        'flex-width' => true,
    ));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, and column width.
     */
    add_editor_style(array('assets/css/editor-style.css', twentyseventeen_fonts_url()));

    // Define and register starter content to showcase the theme on new sites.
    $starter_content = array(
        'widgets' => array(
            // Place three core-defined widgets in the sidebar area.
            'sidebar-1' => array(
                'text_business_info',
                'search',
                'text_about',
            ),
            // Add the core-defined business info widget to the footer 1 area.
            'sidebar-2' => array(
                'text_business_info',
            ),
            // Put two core-defined widgets in the footer 2 area.
            'sidebar-3' => array(
                'text_about',
                'search',
            ),
        ),
        // Specify the core-defined pages to create and add custom thumbnails to some of them.
        'posts' => array(
            'home',
            'about' => array(
                'thumbnail' => '{{image-sandwich}}',
            ),
            'contact' => array(
                'thumbnail' => '{{image-espresso}}',
            ),
            'blog' => array(
                'thumbnail' => '{{image-coffee}}',
            ),
            'homepage-section' => array(
                'thumbnail' => '{{image-espresso}}',
            ),
        ),
        // Create the custom image attachments used as post thumbnails for pages.
        'attachments' => array(
            'image-espresso' => array(
                'post_title' => _x('Espresso', 'Theme starter content', 'twentyseventeen'),
                'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
            ),
            'image-sandwich' => array(
                'post_title' => _x('Sandwich', 'Theme starter content', 'twentyseventeen'),
                'file' => 'assets/images/sandwich.jpg',
            ),
            'image-coffee' => array(
                'post_title' => _x('Coffee', 'Theme starter content', 'twentyseventeen'),
                'file' => 'assets/images/coffee.jpg',
            ),
        ),
        // Default to a static front page and assign the front and posts pages.
        'options' => array(
            'show_on_front' => 'page',
            'page_on_front' => '{{home}}',
            'page_for_posts' => '{{blog}}',
        ),
        // Set the front page section theme mods to the IDs of the core-registered pages.
        'theme_mods' => array(
            'panel_1' => '{{homepage-section}}',
            'panel_2' => '{{about}}',
            'panel_3' => '{{blog}}',
            'panel_4' => '{{contact}}',
        ),
        // Set up nav menus for each of the two areas registered in the theme.
        'nav_menus' => array(
            // Assign a menu to the "top" location.
            'top' => array(
                'name' => __('Top Menu', 'twentyseventeen'),
                'items' => array(
                    'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
                    'page_about',
                    'page_blog',
                    'page_contact',
                ),
            ),
            // Assign a menu to the "social" location.
            'social' => array(
                'name' => __('Social Links Menu', 'twentyseventeen'),
                'items' => array(
                    'link_yelp',
                    'link_facebook',
                    'link_twitter',
                    'link_instagram',
                    'link_email',
                ),
            ),
        ),
    );

    /**
     * Filters Twenty Seventeen array of starter content.
     *
     * @since Twenty Seventeen 1.1
     *
     * @param array $starter_content Array of starter content.
     */
    $starter_content = apply_filters('twentyseventeen_starter_content', $starter_content);

    add_theme_support('starter-content', $starter_content);



    /**
     *
     * custom table creation
     *
     */
    global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    /**
     * 
     * MCQ Question 
     *
     */
    $table_name = $wpdb->prefix . "mcq_question";
    dbDelta("CREATE TABLE  IF NOT EXISTS $table_name(
		question_id INT(11) PRIMARY KEY AUTO_INCREMENT,
		question_text VARCHAR(250) NOT NULL,
		answer1 VARCHAR(250) NOT NULL,
		answer2 VARCHAR(250) NOT NULL,
		answer3 VARCHAR(250) NOT NULL,
        answer4 VARCHAR(250) NOT NULL,
		question_mark INT(2) NOT NULL,
		correct_ans INT(2) NOT NULL,
		cat_id INT(11) NOT NULL
	)");


    /**
     *
     * MCQ Category
     */
    $table_name = $wpdb->prefix . "mcq_category";
    dbDelta("CREATE TABLE  IF NOT EXISTS $table_name(
		cat_id INT(11) PRIMARY KEY AUTO_INCREMENT,
		title VARCHAR(50) NOT NULL
	)");



    /**
     *
     * MCQ Results
     */
    $table_name = $wpdb->prefix . "mcq_results";
    dbDelta("CREATE TABLE  IF NOT EXISTS $table_name(
		result_id INT(11) PRIMARY KEY AUTO_INCREMENT,
		user_id INT(11) NOT NULL,
		exam_date timestamp,
		marks_obtained INT(11) NOT NULL

	)");


    $wpdb->show_errors();
}

add_action('after_setup_theme', 'twentyseventeen_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width() {

    $content_width = $GLOBALS['content_width'];

    // Get layout.
    $page_layout = get_theme_mod('page_layout');

    // Check if layout is one column.
    if ('one-column' === $page_layout) {
        if (twentyseventeen_is_frontpage()) {
            $content_width = 644;
        } elseif (is_page()) {
            $content_width = 740;
        }
    }

    // Check if is single post and there is no sidebar.
    if (is_single() && !is_active_sidebar('sidebar-1')) {
        $content_width = 740;
    }

    /**
     * Filter Twenty Seventeen content width of the theme.
     *
     * @since Twenty Seventeen 1.0
     *
     * @param int $content_width Content width in pixels.
     */
    $GLOBALS['content_width'] = apply_filters('twentyseventeen_content_width', $content_width);
}

add_action('template_redirect', 'twentyseventeen_content_width', 0);

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url() {
    $fonts_url = '';

    /*
     * Translators: If there are characters in your language that are not
     * supported by Libre Franklin, translate this to 'off'. Do not translate
     * into your own language.
     */
    $libre_franklin = _x('on', 'Libre Franklin font: on or off', 'twentyseventeen');

    if ('off' !== $libre_franklin) {
        $font_families = array();

        $font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

        $query_args = array(
            'family' => urlencode(implode('|', $font_families)),
            'subset' => urlencode('latin,latin-ext'),
        );

        $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    }

    return esc_url_raw($fonts_url);
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function twentyseventeen_resource_hints($urls, $relation_type) {
    if (wp_style_is('twentyseventeen-fonts', 'queue') && 'preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }

    return $urls;
}

add_filter('wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentyseventeen_widgets_init() {
    register_sidebar(array(
        'name' => __('Blog Sidebar', 'twentyseventeen'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'twentyseventeen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Footer 1', 'twentyseventeen'),
        'id' => 'sidebar-2',
        'description' => __('Add widgets here to appear in your footer.', 'twentyseventeen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Footer 2', 'twentyseventeen'),
        'id' => 'sidebar-3',
        'description' => __('Add widgets here to appear in your footer.', 'twentyseventeen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'twentyseventeen_widgets_init');

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more($link) {
    if (is_admin()) {
        return $link;
    }

    $link = sprintf('<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>', esc_url(get_permalink(get_the_ID())),
            /* translators: %s: Name of current post */ sprintf(__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen'), get_the_title(get_the_ID()))
    );
    return ' &hellip; ' . $link;
}

add_filter('excerpt_more', 'twentyseventeen_excerpt_more');

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

add_action('wp_head', 'twentyseventeen_javascript_detection', 0);

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">' . "\n", get_bloginfo('pingback_url'));
    }
}

add_action('wp_head', 'twentyseventeen_pingback_header');

/**
 * Display custom color CSS.
 */
function twentyseventeen_colors_css_wrap() {
    if ('custom' !== get_theme_mod('colorscheme') && !is_customize_preview()) {
        return;
    }

    require_once( get_parent_theme_file_path('/inc/color-patterns.php') );
    $hue = absint(get_theme_mod('colorscheme_hue', 250));
    ?>
    <style type="text/css" id="custom-theme-colors" <?php
    if (is_customize_preview()) {
        echo 'data-hue="' . $hue . '"';
    }
    ?>>
    <?php echo twentyseventeen_custom_colors_css(); ?>
    </style>
    <?php
}

add_action('wp_head', 'twentyseventeen_colors_css_wrap');

/**
 * Enqueue scripts and styles.
 */
function twentyseventeen_scripts() {
    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style('twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null);

    // Theme stylesheet.
    wp_enqueue_style('twentyseventeen-style', get_stylesheet_uri());

    // Load the dark colorscheme.
    if ('dark' === get_theme_mod('colorscheme', 'light') || is_customize_preview()) {
        wp_enqueue_style('twentyseventeen-colors-dark', get_theme_file_uri('/assets/css/colors-dark.css'), array('twentyseventeen-style'), '1.0');
    }

    // Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
    if (is_customize_preview()) {
        wp_enqueue_style('twentyseventeen-ie9', get_theme_file_uri('/assets/css/ie9.css'), array('twentyseventeen-style'), '1.0');
        wp_style_add_data('twentyseventeen-ie9', 'conditional', 'IE 9');
    }

    // Load the Internet Explorer 8 specific stylesheet.
    wp_enqueue_style('twentyseventeen-ie8', get_theme_file_uri('/assets/css/ie8.css'), array('twentyseventeen-style'), '1.0');
    wp_style_add_data('twentyseventeen-ie8', 'conditional', 'lt IE 9');

    // Load the html5 shiv.
    wp_enqueue_script('html5', get_theme_file_uri('/assets/js/html5.js'), array(), '3.7.3');
    wp_script_add_data('html5', 'conditional', 'lt IE 9');

    wp_enqueue_script('twentyseventeen-skip-link-focus-fix', get_theme_file_uri('/assets/js/skip-link-focus-fix.js'), array(), '1.0', true);

    $twentyseventeen_l10n = array(
        'quote' => twentyseventeen_get_svg(array('icon' => 'quote-right')),
    );

    if (has_nav_menu('top')) {
        wp_enqueue_script('twentyseventeen-navigation', get_theme_file_uri('/assets/js/navigation.js'), array('jquery'), '1.0', true);
        $twentyseventeen_l10n['expand'] = __('Expand child menu', 'twentyseventeen');
        $twentyseventeen_l10n['collapse'] = __('Collapse child menu', 'twentyseventeen');
        $twentyseventeen_l10n['icon'] = twentyseventeen_get_svg(array('icon' => 'angle-down', 'fallback' => true));
    }

    wp_enqueue_script('twentyseventeen-global', get_theme_file_uri('/assets/js/global.js'), array('jquery'), '1.0', true);

    wp_enqueue_script('jquery-scrollto', get_theme_file_uri('/assets/js/jquery.scrollTo.js'), array('jquery'), '2.1.2', true);

    wp_localize_script('twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'twentyseventeen_scripts');

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr($sizes, $size) {
    $width = $size[0];

    if (740 <= $width) {
        $sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
    }

    if (is_active_sidebar('sidebar-1') || is_archive() || is_search() || is_home() || is_page()) {
        if (!( is_page() && 'one-column' === get_theme_mod('page_options') ) && 767 <= $width) {
            $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
        }
    }

    return $sizes;
}

add_filter('wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2);

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag($html, $header, $attr) {
    if (isset($attr['sizes'])) {
        $html = str_replace($attr['sizes'], '100vw', $html);
    }
    return $html;
}

add_filter('get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3);

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function twentyseventeen_post_thumbnail_sizes_attr($attr, $attachment, $size) {
    if (is_archive() || is_search() || is_home()) {
        $attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
    } else {
        $attr['sizes'] = '100vw';
    }

    return $attr;
}

add_filter('wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3);

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function twentyseventeen_front_page_template($template) {
    return is_home() ? '' : $template;
}

add_filter('frontpage_template', 'twentyseventeen_front_page_template');

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Twenty Seventeen 1.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function twentyseventeen_widget_tag_cloud_args($args) {
    $args['largest'] = 1;
    $args['smallest'] = 1;
    $args['unit'] = 'em';
    $args['format'] = 'list';

    return $args;
}

add_filter('widget_tag_cloud_args', 'twentyseventeen_widget_tag_cloud_args');

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path('/inc/custom-header.php');

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path('/inc/template-tags.php');

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path('/inc/template-functions.php');

/**
 * Customizer additions.
 */
require get_parent_theme_file_path('/inc/customizer.php');

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path('/inc/icon-functions.php');






/**
 *
 * Mcq Question Section
 *
 */
/**
 *
 * insert question
 *
 */
add_action('wp_dashboard_setup', 'question_insert_func');

function question_insert_func() {
    wp_add_dashboard_widget('question_insert', 'Manage Questions', 'question_form_func');
}

/**
 *
 * dashboard content
 *
 */
function question_form_func() {

    global $wpdb;
    $error = array();

    if (isset($_POST['submit_question'])) {

        $title          = $_POST['title'];
        $ans1           = $_POST['ans_1'];
        $ans2           = $_POST['ans_2'];
        $ans3           = $_POST['ans_3'];
        $ans4           = $_POST['ans_4'];
        $question_mark  = $_POST['question_mark'];

        $correct_ans = $_POST['correctanswer'];
        $mcq_category = $_POST['mcq_cat'];


        if (empty($title)) {
            $error['title'] = "Queston field can'b be blank";
        }


        $error_num = count($error);
        echo $error_num;
        if ($error_num === 0) {
            $table = $wpdb->prefix . "mcq_question";
            $insert_info = $wpdb->insert(
                    // table name
                    $table,
                    // column names as a key + name field as a value 
                    array(
                'question_text' => $title,
                'answer1' => $ans1,
                'answer2' => $ans2,
                'answer3' => $ans3,
                'answer4' => $ans4,
                'question_mark' => $question_mark,
                'correct_ans' => $correct_ans,
                'cat_id' => $mcq_category,
                    ),
                    // define the data type %s = String, %d = integer and %f = float
                    array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d'
                    )
            );
            if ($insert_info) {
                $sucss = "You are successful";
            }
        }
    }
    ?>

    <form action="" method="post">



        <table>
            <tr>
                <td><label for="title">Question</label></td>
                <td><input type="text" name="title" id="title" class=""></td>
                <?php
                if (isset($error['title'])) {
                    echo "<td>" . $error['title'] . "</td>";
                }
                ?>
            </tr>	


            <tr>
                <td><label for="ans_1">Answer 1</label></td>
                <td><input type="text" name="ans_1" id="ans_1" class=""> IsCorrect? <input type="radio" name="correctanswer" value="1"/></td>

            </tr>

            <tr>
                <td><label for="ans_2">Answer 2</label></td>
                <td><input type="text" name="ans_2" id="ans_2" class=""> IsCorrect? <input type="radio" name="correctanswer" value="2"/></td>

            </tr>

            <tr>
                <td><label for="ans_3">Answer 3</label></td>
                <td><input type="text" name="ans_3" id="ans_3" class=""> IsCorrect? <input type="radio" name="correctanswer" value="3"/></td>

            </tr>


            <tr>
                <td><label for="ans_4">Answer 4</label></td>
                <td><input type="text" name="ans_4" id="ans_4" class="">  IsCorrect? <input type="radio" name="correctanswer" value="3"/></td>

            </tr>

            <tr>
                <td><label for="question_mark">Question Mark</label></td>
                <td><input type="number" name="question_mark" id="question_mark" class="question_mark">  </td>

            </tr>

            <tr>
                <td><label for="title">Select Category</label></td>

                <td>
                    <select name="mcq_cat" id="">
                        <?php
                        $table = $wpdb->prefix . "mcq_category";
                        $all_categorys = $wpdb->get_results("SELECT * FROM $table");

                        foreach ($all_categorys as $value) {
                            ?>

                            <option value="<?php echo $value->cat_id; ?>"><?php echo $value->title; ?></option>

                        <?php } ?>
                    </select>
                </td>

            </tr>

            <tr>
                <td></td>
                <td><input type="submit" value="Add Question" name="submit_question" class="button button-primary"></td>
            </tr>
        </table>

    </form>

    <?php
    if (isset($sucss)) {
        echo $sucss;
    }
    ?>


<hr />
<hr />
<!-- view questions -->


<?php
$table = $wpdb->prefix."mcq_question";
$infos = $wpdb->get_results("SELECT * FROM $table");
echo "<pre>";
     // print_r($infos);
echo "</pre>";
?>
<table border="1">
    <tr>    
        <th>Sl. No</th>
        <th>Question</th>
        <th>Marks</th>
        <th>Update Info</th>
    </tr>
    <?php
    $x = 1;
    foreach ($infos as $value) { ?>
    <tr>    
        <td><?php echo $x++; ?></td>
        <td><?php echo $value->question_text; ?></td>
        <td><?php echo $value->question_mark; ?></td>
        <td><a href="?quesion_edit=<?php echo $value->question_id; ?>">Edit</a> <a href="?question_delete=<?php echo $value->question_id; ?>">Delete</a></td>
    </tr>
    <?php   } ?>

</table>
<!-- end view questions -->



<!-- update question -->
<?php 
if( isset($_GET['quesion_edit']) ): 
    echo "<hr /><hr />";
    $edit_id = $_GET['quesion_edit'];
    $view_info = $wpdb->get_results("SELECT * FROM $table WHERE question_id=$edit_id");
    ?>

<form action="" method="post">
    
    <?php foreach ($view_info as $value) { ?>
    <table>
        
        <tr>
            <td><label for="fname">Edit Question</label></td>
            <td><textarea name="update_question" id="" cols="30" rows="4"><?php echo $value->question_text; ?></textarea></td>
            
        </tr>
        <tr>
            <td><label for="fname">Edit Marks</label></td>
            <td><input type="text" name="update_marks" value="<?php echo $value->question_mark; ?>"></td>
            
        </tr>
        
        <tr>
            <td><label for="fname">Correct Ans</label></td>
            <td><input type="text" name="update_correct_ans" value="<?php echo $value->correct_ans; ?>"></td>
            
        </tr>
        
        <tr>
            <td><label for="fname">Choice 1 </label></td>
            <td><input type="text" name="update_choice_1" value="<?php echo $value->answer1; ?>"></td>
            
        </tr>        
        <tr>
            <td><label for="fname">Choice 2 </label></td>
            <td><input type="text" name="update_choice_2" value="<?php echo $value->answer2; ?>"></td>
            
        </tr>        
        <tr>
            <td><label for="fname">Choice 3 </label></td>
            <td><input type="text" name="update_choice_3" value="<?php echo $value->answer3; ?>"></td>
            
        </tr>        

        <tr>
            <td><label for="fname">Choice 4 </label></td>
            <td><input type="text" name="update_choice_4" value="<?php echo $value->answer4; ?>"></td>
            
        </tr>


        <tr>
            <td></td>
            <td><input type="submit" value="Update Now" name="update_info"></td>
        </tr>
    </table>
    <?php } ?>

</form>






<?php endif; ?> <!-- end of update -->


<?php } ?>




<!-- update info -->
<?php 
if( isset($_POST['update_info']) ){
    $edit_id = $_GET['quesion_edit'];
    $title = $_POST['update_question'];
    $marks = $_POST['update_marks'];
    $correct_ans = $_POST['update_correct_ans'];
    $update_choice_1 = $_POST['update_choice_1'];
    $update_choice_2 = $_POST['update_choice_2'];
    $update_choice_3 = $_POST['update_choice_3'];
    $update_choice_4 = $_POST['update_choice_4'];

    
    $table = $wpdb->prefix."mcq_question";
    $update_info = $wpdb->replace( 
        // table name
        $table, 
        // column names as a key + name field as a value 
        array(
            'question_id' => $edit_id,
            'question_text' => $title,
            'question_mark' => $marks,
            'correct_ans' => $correct_ans,
            'answer1' => $update_choice_1,
            'answer2' => $update_choice_2,
            'answer3' => $update_choice_3,
            'answer4' => $update_choice_4,
        )
    );
    
}
/**
* delete info
*
*/
if( isset($_GET['question_delete']) ){
    $delete_id = $_GET['question_delete'];
    // $q = "DELETE FROM questions  WHERE question_id = $delete_id";
    
    // $con->query($q);
    // header('Location: view_questions.php');
    $table = $wpdb->prefix."mcq_question";
    $wpdb->delete( $table, array( 'question_id' => $delete_id ), array( '%d' ) );
    wp_redirect( admin_url() );
}
?>











<?php
/* * ************************************
 *
 * 			Category MCQ
 *
 * ************************************* */



/**
 *
 * Manage options
 *
 */
add_action('wp_dashboard_setup', 'options_insert_func');

function options_insert_func() {
    wp_add_dashboard_widget('options_insert', 'Manage Category', 'category_form_func');
}

/**
 *
 * dashboard content
 *
 */
function category_form_func() {

    global $wpdb;
    $error = array();
    if (isset($_POST['submit_option'])):
        $title = $_POST['title'];


        if (empty($title)) {
            $error['title'] = "Label field can'b be blank";
        }

        $error_num = count($error);

        if ($error_num === 0) {
            $table = $wpdb->prefix . "mcq_category";
            $insert_info = $wpdb->insert(
                    // table name
                    $table,
                    // column names as a key + name field as a value 
                    array(
                'title' => $title
                    ),
                    // define the data type %s = String, %d = integer and %f = float
                    array(
                '%s'
                    )
            );
            if ($insert_info) {
                $sucss = "Options is added successful";
            }
        }
    endif;
    ?>

    <form action="" method="post">



        <table>
            <tr>
                <td><label for="label_title">Name </label></td>
                <td><input type="text" name="title" id="label_title" class=""></td>
                <?php
                if (isset($error['title'])) {
                    echo "<td>" . $error['title'] . "</td>";
                }
                ?>
            </tr>


            <tr>
                <td></td>
                <td><input type="submit" value="Add Category" name="submit_option" class="button button-primary"></td>
            </tr>
        </table>

    </form>

    <?php
    if (isset($sucss)) {
        echo $sucss;
    }
    ?>



    <hr />
    <hr />
    <!-- view options -->


    <?php
    $table = $wpdb->prefix . "mcq_category";
    $all_categorys = $wpdb->get_results("SELECT * FROM $table");
    echo "<pre>";
    // print_r($all_categorys);
    echo "</pre>";
    ?>
    <table border="1">
        <tr>	
            <th>Sl. No</th>
            <th>Label</th>
            <th>Update Info</th>
        </tr>
        <?php
        $x = 1;
        foreach ($all_categorys as $value) {
            ?>
            <tr>	
                <td><?php echo $x++; ?></td>
                <td><?php echo $value->title; ?></td>
                <td><a href="?edit=<?php echo $value->cat_id; ?>">Edit</a> <a href="?delete=<?php echo $value->cat_id; ?>">Delete</a></td>
            </tr>
        <?php } ?>

    </table>
    <!-- end view options -->





    <?php
    if (isset($_GET['edit'])):
        echo "<hr /><hr />";
        echo "<h2> Edit Options</h2>";
        $edit_id = $_GET['edit'];
        $all_ans_options = $wpdb->get_results("SELECT * FROM $table WHERE cat_id=$edit_id");
        ?>

        <form action="" method="post">

            <?php foreach ($all_ans_options as $value) { ?>
                <table>
                    <tr>
                        <td><label for="fname">Edit Label</label></td>
                        <td><input type="text" name="update_title" value="<?php echo $value->title; ?>" id="fname"></td>

                    </tr>


                    <tr>
                        <td></td>
                        <td><input type="submit" value="Update Option" name="update_options"></td>
                    </tr>
                </table>
            <?php } ?>

        </form>






    <?php endif; ?> <!-- end of update -->




    <?php
}

// end of widget content options 
/** update info * */
if (isset($_POST['update_options'])) {
    $edit_id = $_GET['edit'];
    $label = $_POST['update_title'];

    $table = $wpdb->prefix . "mcq_category";
    $update_info = $wpdb->replace(
            // table name
            $table,
            // column names as a key + name field as a value 
            array(
        'cat_id' => $edit_id,
        'title' => $label
            )
    );
}
/**
 * delete info
 *
 */
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    // $q = "DELETE FROM questions  WHERE question_id = $delete_id";
    // $con->query($q);
    // header('Location: view_questions.php');
    $table = $wpdb->prefix . "mcq_category";
    $wpdb->delete($table, array('cat_id' => $delete_id), array('%d'));
    wp_redirect(admin_url());
}
?>















<?php


/* * ************************************************************
 *
 *
 * 	Show Question
 * 	With Shortcode
 *
 *
 * **************************************************************** */
add_shortcode('comet_exam_survey', 'comet_exam_survey_func');

function comet_exam_survey_func($atts, $content) {
    global $wpdb;
   // add_action('init', 'start_session', 1);
    /**
     *
     * all $_SESSION["current_mcq_no"]questions/////////////////////////////////////////////////////////////////////////////////////////////////////////////
     */
    if(session_id() == ''){
     session_start(); 
    }

    /**
    *
    * checking the exam condition here
    * 
    */
    $exam_table = $wpdb->prefix . "mcq_results";
    $current_user_id = get_current_user_id();
    $exam_data = $wpdb->get_results("SELECT * FROM $exam_table WHERE user_id='$current_user_id' ORDER BY result_id DESC");
    $count_exam = count($exam_data);


    if($count_exam > 1){
        if ($exam_data[0]->marks_obtained > 90) {
            echo "You have passed the exam and you got ".$exam_data[0]->marks_obtained;
        }else{
            echo "Sorry you failed and unable to perform exam you got ".$exam_data[0]->marks_obtained;
        }
       exit();
    }elseif($count_exam = 1){
            if ($exam_data[0]->marks_obtained > 90) {
                echo "You have passed the exam and you got ".$exam_data[0]->marks_obtained;
                exit();
            }else{
                
            }
        }else{

        }

     
    
    /**
    *
    * end of checking the exam condition here
    * 
    */
    
    $questions_table = $wpdb->prefix . "mcq_question";
    $_SESSION['quiz'] = $wpdb->get_results("SELECT * FROM $questions_table");
    $quiz_count = count($_SESSION['quiz']);


    /**
     *
     * all Users
     *
     */
    $users_table = $wpdb->prefix . "users";
    $all_users = $wpdb->get_results("SELECT * FROM $users_table");
    $user_id = get_current_user_id();



 if(isset($_POST["survey_info"]))
{
    $current_mcq_no = $_SESSION["current_mcq_no"];
    $current_mcq = $_SESSION["quiz"][$current_mcq_no];
    
    if($current_mcq_no < $quiz_count) {
        $submitted_mcq_no = $current_mcq_no - 1;
        
        $submitted_mcq = $_SESSION["quiz"][$submitted_mcq_no];
        if(isset($_POST["answer"])) {
            if($_POST["answer"] == $current_mcq->correct_ans){
                $_SESSION["answers"] += $current_mcq->question_mark;
                
            } else{
                $_SESSION["answers"] += 0;
            }
        } else {
            $_SESSION["answers"] += 0;       
        }
        $_SESSION["current_mcq_no"] = $current_mcq_no + 1;
      
    } else {
       
        $submitted_mcq_no = $current_mcq_no - 1;
        $submitted_mcq = $_SESSION["quiz"][$submitted_mcq_no];
        if(isset($_POST["answer"])) {
             
            if($_POST["answer"] == $submitted_mcq->correct_ans){
                $_SESSION["answers"] += $submitted_mcq->question_mark;
            } else{
                 $_SESSION["answers"] += 0;
            }
        } else {
             $_SESSION["answers"] += 0;        
        }
           
        /**
        *
        * inserting data to database by tajujl
        *
        */
  
        $total_marks =  $_SESSION["answers"];

           $q ="INSERT INTO wp_mcq_results(user_id, exam_date, marks_obtained) VALUES('$user_id', CURRENT_TIMESTAMP, '$total_marks')";

           $all_data = $wpdb->query($q);

        

           if( isset($total_marks) ){
                if($total_marks >= 90){
                    echo "You got $total_marks out of 100. You have passed the exam ";
                }elseif ($total_marks < 90) { 
                    if($cout_exam < 2){
                        echo "You got $total_marks and you can retake the exam again ";
                        echo ' <a href="http://corlate.lh/shortcode-test/">Exam Again</a>';
                    }else{
                        echo "You got $total_marks out of 100. You have failed";
                    }
                }
           }

            
           

        /**
        *
        * end of insert data
        *
        */
        exit;
    }
} else {
    unset($_SESSION["answers"]);
    $current_mcq_no = $_SESSION["current_mcq_no"] = 0;
    $current_mcq = $_SESSION["quiz"][$current_mcq_no];
    $_SESSION["current_mcq_no"] = $current_mcq_no + 1;
    
   // var_dump($current_mcq);
}
//var_dump($_SESSION["answers"]);

// var_dump($_SESSION["current_mcq_no"]);
    ?>

    <form action="" method="post">

        <p>
            <label for=""><?php echo $current_mcq->question_text; ?></label>
                <input type="radio" name="answer" value="1"><?php echo $current_mcq->answer1; ?><br />
               <input type="radio" name="answer" value="2"><?php echo $current_mcq->answer2; ?><br />
               <input type="radio" name="answer" value="3"><?php echo $current_mcq->answer3; ?><br />
               <input type="radio" name="answer" value="4"><?php echo $current_mcq->answer4; ?>

        </p>
        <p>
            <input type="submit" value="Submit" name="survey_info">
        </p>
			
    </form>
    <?php
    return ob_get_clean();
}



/**
*
* extra link for creating question
*
*/
add_shortcode('comet_start_quiz', 'start_quiz');

function start_quiz($atts, $content) {
    global $wpdb;
    /**
     *
     * all Users
     *
     */
    $users_table = $wpdb->prefix . "users";
    $all_users = $wpdb->get_results("SELECT * FROM $users_table");    

  
    $exam_table = $wpdb->prefix . "mcq_results";
    $current_user_id = get_current_user_id();
    $exam_data = $wpdb->get_results("SELECT * FROM $exam_table WHERE user_id='$current_user_id'");



    echo "<pre>";
        print_r($exam_data);
    echo "</pre>";  


    ob_start();
    ?>

    

     <a href="http://corlate.lh/shortcode-test/">Lets go</a>




    <?php
    return ob_get_clean();
}



/***
*
*
* Plugin Decoration
*
*
*
*/


/**
 * Register a custom menu page.
 */

