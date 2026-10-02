<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '3.5.1' );
define( 'EHP_THEME_SLUG', 'hello-elementor' );

define( 'HELLO_THEME_PATH', get_template_directory() );
define( 'HELLO_THEME_URL', get_template_directory_uri() );
define( 'HELLO_THEME_ASSETS_PATH', HELLO_THEME_PATH . '/assets/' );
define( 'HELLO_THEME_ASSETS_URL', HELLO_THEME_URL . '/assets/' );
define( 'HELLO_THEME_SCRIPTS_PATH', HELLO_THEME_ASSETS_PATH . 'js/' );
define( 'HELLO_THEME_SCRIPTS_URL', HELLO_THEME_ASSETS_URL . 'js/' );
define( 'HELLO_THEME_STYLE_PATH', HELLO_THEME_ASSETS_PATH . 'css/' );
define( 'HELLO_THEME_STYLE_URL', HELLO_THEME_ASSETS_URL . 'css/' );
define( 'HELLO_THEME_IMAGES_PATH', HELLO_THEME_ASSETS_PATH . 'images/' );
define( 'HELLO_THEME_IMAGES_URL', HELLO_THEME_ASSETS_URL . 'images/' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		if ( apply_filters( 'hello_elementor_register_menus', true ) ) {
			register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello-elementor' ) ] );
		}

		if ( apply_filters( 'hello_elementor_post_type_support', true ) ) {
			add_post_type_support( 'page', 'excerpt' );
		}

		if ( apply_filters( 'hello_elementor_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
					'navigation-widgets',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);
			add_theme_support( 'align-wide' );
			add_theme_support( 'responsive-embeds' );

			/*
			 * Editor Styles
			 */
			add_theme_support( 'editor-styles' );
			add_editor_style( 'assets/css/editor-styles.css' );

			/*
			 * WooCommerce.
			 */
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', true ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_display_header_footer' ) ) {
	/**
	 * Check whether to display header footer.
	 *
	 * @return bool
	 */
	function hello_elementor_display_header_footer() {
		$hello_elementor_header_footer = true;

		return apply_filters( 'hello_elementor_header_footer', $hello_elementor_header_footer );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		if ( apply_filters( 'hello_elementor_enqueue_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor',
				HELLO_THEME_STYLE_URL . 'reset.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				HELLO_THEME_STYLE_URL . 'theme.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( hello_elementor_display_header_footer() ) {
			wp_enqueue_style(
				'hello-elementor-header-footer',
				HELLO_THEME_STYLE_URL . 'header-footer.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hello_elementor_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( ! function_exists( 'hello_elementor_add_description_meta_tag' ) ) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag() {
		if ( ! apply_filters( 'hello_elementor_description_meta_tag', true ) ) {
			return;
		}

		if ( ! is_singular() ) {
			return;
		}

		$post = get_queried_object();
		if ( empty( $post->post_excerpt ) ) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );

// Settings page
require get_template_directory() . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor
require get_template_directory() . '/includes/elementor-functions.php';

if ( ! function_exists( 'hello_elementor_customizer' ) ) {
	// Customizer controls
	function hello_elementor_customizer() {
		if ( ! is_customize_preview() ) {
			return;
		}

		if ( ! hello_elementor_display_header_footer() ) {
			return;
		}

		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_elementor_customizer' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check whether to display the page title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );


function brandstory_statistics_shortcode() {
    ob_start();
    ?>
	<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .bs-stats-wrapper {
            position: relative;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            font-family: 'Hanken Grotesk', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        .bs-stats-banner {
            background: url('http://brandstory-agency/wp-content/uploads/2026/10/Frame-1707483040.png');
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 16px;
            padding: 40px 20px 120px 20px;
            text-align: center;
            color: #ffffff;
        }
        .bs-stats-banner h2 {
            font-size: 28px;
            font-weight: 700;
            color: black;
            margin: 0;
        }
        .bs-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            max-width: 1100px;
            margin: -60px auto 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }
        .bs-stat-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 35px 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        .bs-stat-number {
            font-size: 38px;
            font-weight: 700;
            color: #9333ea;
            margin-bottom: 10px;
            line-height: 1;
        }
        .bs-stat-label {
            font-size: 15px;
            color: #1f2937;
            font-weight: 500;
            margin: 0;
        }
        @media (max-width: 768px) {
            .bs-stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media (max-width: 480px) {
            .bs-stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="bs-stats-wrapper">
        <div class="bs-stats-banner">
            <h2>Our Statistics</h2>
        </div>
        <div class="bs-stats-grid">
            <div class="bs-stat-card">
                <div class="bs-stat-number">350+</div>
                <p class="bs-stat-label">Campaigns Executed</p>
            </div>
            <div class="bs-stat-card">
                <div class="bs-stat-number">180+</div>
                <p class="bs-stat-label">Satisfied Clients</p>
            </div>
            <div class="bs-stat-card">
                <div class="bs-stat-number">10+</div>
                <p class="bs-stat-label">Satisfied Clients</p>
            </div>
            <div class="bs-stat-card">
                <div class="bs-stat-number">600+</div>
                <p class="bs-stat-label">Cups of Coffee</p>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('brandstory_stats', 'brandstory_statistics_shortcode');

function brandstory_team_slider_shortcode() {
    ob_start();
    ?>
	<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .bs-team-wrapper {
            position: relative;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            font-family: 'Hanken Grotesk', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            padding: 40px 20px;
        }
        .bs-team-header-row {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 20px;
        }
        .bs-team-nav-buttons {
            display: flex;
            gap: 12px;
        }
        .bs-team-arrow {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: white;
            border: 2px solid #ffffff;
            color: black;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 30px;
        }
        .bs-team-arrow:hover {
            background-color: #a855f7;
            border-color: #a855f7;
            color: #ffffff;
        }
        .bs-team-slider {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 15px;
            scrollbar-width: none; /* Firefox */
        }
        .bs-team-slider::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        .bs-team-card {
            flex: 0 0 280px;
            height: 340px;
            border-radius: 16px;
            overflow: hidden;
            background-color: #1a1a1a;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        .bs-team-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
    </style>

    <div class="bs-team-wrapper">
        <div class="bs-team-header-row">
            <div class="bs-team-nav-buttons">
                <button class="bs-team-arrow" id="bs-slide-left">&#8592;</button>
                <button class="bs-team-arrow" id="bs-slide-right">&#8594;</button>
            </div>
        </div>
        <div class="bs-team-slider" id="bs-team-container">
            <div class="bs-team-card">
                <img src="http://brandstory-agency/wp-content/uploads/2026/10/pexels-divinetechygirl-1181675.jpg" alt="Team Member">
            </div>
            <div class="bs-team-card">
                <img src="http://brandstory-agency/wp-content/uploads/2026/10/pexels-mikhail-nilov-7988089.jpg" alt="Team Member">
            </div>
            <div class="bs-team-card">
                <img src="http://brandstory-agency/wp-content/uploads/2026/10/pexels-mikhail-nilov-7988086.jpg" alt="Team Member">
            </div>
            <div class="bs-team-card">
                <img src="http://brandstory-agency/wp-content/uploads/2026/10/pexels-mizunokozuki-12899165.jpg" alt="Team Member">
            </div>
            <div class="bs-team-card">
                <img src="http://brandstory-agency/wp-content/uploads/2026/10/pexels-ofspace-16323580.jpg" alt="Team Member">
            </div>
            <div class="bs-team-card">
                <img src="http://brandstory-agency/wp-content/uploads/2026/10/pexels-zayed-hossain-52728970-36706459.jpg" alt="Team Member">
            </div>
            <div class="bs-team-card">
                <img src="http://brandstory-agency/wp-content/uploads/2026/10/pexels-varun-bhatheja-2163946837-39342696.jpg" alt="Team Member">
            </div>
        </div>
    </div>

    <script>
        document.getElementById('bs-slide-right').addEventListener('click', function() {
            document.getElementById('bs-team-container').scrollBy({ left: 300, behavior: 'smooth' });
        });
        document.getElementById('bs-slide-left').addEventListener('click', function() {
            document.getElementById('bs-team-container').scrollBy({ left: -300, behavior: 'smooth' });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('brandstory_team', 'brandstory_team_slider_shortcode');

function brandstory_faq_case_studies_shortcode() {
    ob_start();
    ?>
	<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .bs-section-wrapper {
            position: relative;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            font-family: 'Hanken Grotesk', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            padding: 40px 20px;
            color: #ffffff;
        }
        
        /* FAQ Section Styles */
        .bs-faq-title {
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 30px;
        }
        .bs-faq-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 60px;
        }
        .bs-faq-item {
            background-color: #1a1a1a;
            border-radius: 12px;
            padding: 20px;
            cursor: pointer;
            border: 1px solid #2a2a2a;
            transition: all 0.3s ease;
        }
        .bs-faq-item.active {
            background-color: #222222;
        }
        .bs-faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 16px;
            font-weight: 600;
        }
        .bs-faq-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background-color: #2a2a2a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        .bs-faq-item.active .bs-faq-icon {
            background-color: #a855f7;
            transform: rotate(180deg);
        }
        .bs-faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, margin-top 0.3s ease;
            font-size: 14px;
            color: #b0b0b0;
            line-height: 1.6;
        }
        .bs-faq-item.active .bs-faq-answer {
            max-height: 150px;
            margin-top: 12px;
        }

       
        .bs-cs-header-row {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            margin-bottom: 30px;
        }
        .bs-cs-title {
            text-align: center;
            font-size: 26px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 20px;
        }
        .bs-cs-nav-buttons {
            display: flex;
            gap: 12px;
            align-self: flex-end;
        }
        .bs-cs-arrow {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: white;
            border: 2px solid #ffffff;
            color: black;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 30px;
        }
        .bs-cs-arrow:hover {
            background-color: #a855f7;
            border-color: #a855f7;
            color: #ffffff;
        }
        .bs-cs-slider {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 15px;
            scrollbar-width: none;
        }
        .bs-cs-slider::-webkit-scrollbar {
            display: none;
        }
        .bs-cs-card {
            flex: 0 0 350px;
            height: 450px;
            border-radius: 16px;
            overflow: hidden;
            background-color: #1a1a1a;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        .bs-cs-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        @media (max-width: 768px) {
            .bs-cs-nav-buttons {
                align-self: center;
                margin-top: 15px;
            }
        }
    </style>

    <div class="bs-section-wrapper">
        
        <h2 class="bs-faq-title">FAQ's</h2>
        <div class="bs-faq-list">
            <div class="bs-faq-item active">
                <div class="bs-faq-question">
                    <span>How Does Digital Marketing Support Business Growth In Abu Dhabi?</span>
                    <div class="bs-faq-icon">&#9650;</div>
                </div>
                <div class="bs-faq-answer">
                    Digital Marketing Helps Businesses In Abu Dhabi Build Visibility, Attract Relevant Audiences, And Convert Interest Into Leads Through A Mix Of Search, Social, Content, And Performance Channels.
                </div>
            </div>
            <div class="bs-faq-item">
                <div class="bs-faq-question">
                    <span>Which Digital Marketing Channels Work Best For Abu Dhabi Businesses?</span>
                    <div class="bs-faq-icon">&#9660;</div>
                </div>
                <div class="bs-faq-answer">
                    A combination of SEO, targeted PPC campaigns, and active social media management deliver the most robust sustainable growth.
                </div>
            </div>
            <div class="bs-faq-item">
                <div class="bs-faq-question">
                    <span>How Is Local Market Understanding Important In Digital Marketing?</span>
                    <div class="bs-faq-icon">&#9660;</div>
                </div>
                <div class="bs-faq-answer">
                    Understanding regional consumer behavior and local intent helps tailor messaging that converts target demographics more effectively.
                </div>
            </div>
            <div class="bs-faq-item">
                <div class="bs-faq-question">
                    <span>How Long Does It Take To See Results From Digital Marketing?</span>
                    <div class="bs-faq-icon">&#9660;</div>
                </div>
                <div class="bs-faq-answer">
                    PPC delivers instant traffic, while organic SEO and content initiatives generally show significant compounding results within 3 to 6 months.
                </div>
            </div>
            <div class="bs-faq-item">
                <div class="bs-faq-question">
                    <span>Can Digital Marketing Help Reach Both Local And Regional Audiences?</span>
                    <div class="bs-faq-icon">&#9660;</div>
                </div>
                <div class="bs-faq-answer">
                    Yes, geo-targeted campaigns allow you to zero in strictly on Abu Dhabi clients while scalable campaigns expand across the wider region.
                </div>
            </div>
        </div>

        
        <div class="bs-cs-header-row">
            <h2 class="bs-cs-title">Proven Digital Marketing Success Our<br>Abu Dhabi Case Studies</h2>
            <div class="bs-cs-nav-buttons">
                <button class="bs-cs-arrow" id="bs-cs-left">&#8592;</button>
                <button class="bs-cs-arrow" id="bs-cs-right">&#8594;</button>
            </div>
        </div>
        
        <div class="bs-cs-slider" id="bs-cs-container">
            <div class="bs-cs-card">
                <img src="http://brandstory-agency/wp-content/uploads/2026/10/campaign-creators-gMsnXqILjp4-unsplash.jpg" alt="Case Study">
            </div>
            <div class="bs-cs-card">
                <img src="http://brandstory-agency/wp-content/uploads/2026/10/andrew-neel-cckf4TsHAuw-unsplash.jpg" alt="Case Study">
            </div>
            <div class="bs-cs-card">
                <img src="http://brandstory-agency/wp-content/uploads/2026/10/brooke-cagle-g1Kr4Ozfoac-unsplash.jpg" alt="Case Study">
            </div>
            <div class="bs-cs-card">
                <img src="http://brandstory-agency/wp-content/uploads/2026/10/kobu-agency-7okkFhxrxNw-unsplash.jpg" alt="Case Study">
            </div>
            <div class="bs-cs-card">
                <img src="http://brandstory-agency/wp-content/uploads/2026/10/olena-bohovyk-dIMJWLx1YbE-unsplash.jpg" alt="Case Study">
            </div>
            <div class="bs-cs-card">
                <img src="http://brandstory-agency/wp-content/uploads/2026/10/charlesdeluvio-Lks7vei-eAg-unsplash.jpg" alt="Case Study">
            </div>
        </div>
    </div>

    <script>
        
        document.querySelectorAll('.bs-faq-item').forEach(item => {
            item.querySelector('.bs-faq-question').addEventListener('click', () => {
                const isOpen = item.classList.contains('active');
                document.querySelectorAll('.bs-faq-item').forEach(other => {
                    other.classList.remove('active');
                    other.querySelector('.bs-faq-icon').innerHTML = '&#9660;';
                });
                if (!isOpen) {
                    item.classList.add('active');
                    item.querySelector('.bs-faq-icon').innerHTML = '&#9650;';
                }
            });
        });

        
        document.getElementById('bs-cs-right').addEventListener('click', function() {
            document.getElementById('bs-cs-container').scrollBy({ left: 370, behavior: 'smooth' });
        });
        document.getElementById('bs-cs-left').addEventListener('click', function() {
            document.getElementById('bs-cs-container').scrollBy({ left: -370, behavior: 'smooth' });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('brandstory_faq_cs', 'brandstory_faq_case_studies_shortcode');
/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		wp_body_open();
	}
}

require HELLO_THEME_PATH . '/theme.php';

HelloTheme\Theme::instance();
