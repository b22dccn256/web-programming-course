<?php
// Load CSS Astra Parent + Child
add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_styles' );
function astra_child_enqueue_styles() {
    wp_enqueue_style( 'astra-parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'astra-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('astra-parent-style'),
        wp_get_theme()->get('Version')
    );
}

// Đăng ký Custom Post Type: Sản phẩm Affiliate
add_action( 'init', 'nhonhoxinh_register_san_pham' );
function nhonhoxinh_register_san_pham() {
    $labels = array(
        'name'               => 'Sản phẩm Affiliate',
        'singular_name'      => 'Sản phẩm',
        'add_new_item'       => 'Thêm sản phẩm mới',
        'edit_item'          => 'Sửa sản phẩm',
        'all_items'          => 'Tất cả sản phẩm',
        'menu_name'          => 'Sản phẩm',
    );

    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-cart',
        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'has_archive'   => true,
        'rewrite'       => array( 'slug' => 'san-pham' ),
        'show_in_rest'  => true,
    );

    register_post_type( 'san_pham_aff', $args );
}

// Shortcode 1: [san_pham_noi_bat so_luong="6"]  --> Lưới 3 cột
add_shortcode( 'san_pham_noi_bat', 'nhonhoxinh_shortcode_san_pham' );
function nhonhoxinh_shortcode_san_pham( $atts ) {

    $atts = shortcode_atts( array(
        'so_luong' => 6,
    ), $atts );

    $query = new WP_Query( array(
        'post_type'      => 'san_pham_aff',
        'posts_per_page' => intval( $atts['so_luong'] ),
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    if ( ! $query->have_posts() ) {
        return '<p>Chưa có sản phẩm nào.</p>';
    }

    ob_start();
    ?>
    <div class="nnx-san-pham-grid">
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div class="nnx-san-pham-item">
                <a href="<?php the_permalink(); ?>">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'medium' ); ?>
                    <?php endif; ?>
                    <h3><?php the_title(); ?></h3>
                </a>
                <p><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <style>
        .nnx-san-pham-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .nnx-san-pham-item {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }
        .nnx-san-pham-item:hover {
            transform: translateY(-5px);
        }
        .nnx-san-pham-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 10px;
        }
        @media (max-width: 768px) {
            .nnx-san-pham-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
    <?php
    wp_reset_postdata();
    return ob_get_clean();
}

// Shortcode 2: [san_pham_hot so_luong="6"]  --> Carousel trượt ngang
add_shortcode( 'san_pham_hot', 'nhonhoxinh_shortcode_carousel' );
function nhonhoxinh_shortcode_carousel( $atts ) {

    $atts = shortcode_atts( array( 'so_luong' => 5 ), $atts );

    $query = new WP_Query( array(
        'post_type'      => 'san_pham_aff',
        'posts_per_page' => intval( $atts['so_luong'] ),
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    if ( ! $query->have_posts() ) {
        return '<p>Chưa có sản phẩm nào.</p>';
    }

    $uid = 'nnx-car-' . mt_rand( 1000, 9999 );

    ob_start();
    ?>
    <div class="nnx-carousel-wrap">
        <div class="nnx-carousel-nav">
            <button onclick="nnxScroll('<?php echo $uid; ?>', -1)">&#10094;</button>
            <button onclick="nnxScroll('<?php echo $uid; ?>', 1)">&#10095;</button>
        </div>
        <div class="nnx-carousel" id="<?php echo $uid; ?>">
            <?php while ( $query->have_posts() ) : $query->the_post();
                $gia  = get_post_meta( get_the_ID(), 'gia-tien', true );
                $link = get_post_meta( get_the_ID(), 'link-san-pham', true );
                $url  = $link ? $link : get_permalink();
            ?>
                <div class="nnx-citem">
                    <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="nofollow noopener">
                        <?php if ( has_post_thumbnail() ) the_post_thumbnail( 'medium' ); ?>
                    </a>
                    <h4><?php the_title(); ?></h4>
                    <?php if ( $gia ) : ?>
                        <p class="nnx-price"><?php echo number_format( str_replace( '.', '', $gia ), 0, ',', '.' ); ?>đ</p>
                    <?php else : ?>
                        <p class="nnx-price">Liên hệ</p>
                    <?php endif; ?>
                    <a class="nnx-buy" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="nofollow noopener">Mua ngay</a>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>

    <style>
        .nnx-carousel-wrap { position: relative; }
		.nnx-carousel-nav { display:flex; justify-content:flex-end; gap:8px; margin-bottom:10px; }
        .nnx-carousel-nav button {
            border:1px solid #ddd;
            background:#fff;
            width:32px;
            height:32px;
            padding:0;
            margin:0;
            border-radius:50%;
            cursor:pointer;
            display:flex;
            align-items:center;
            justify-content:center;
            line-height:1;
            font-size:14px;
        }
        .nnx-carousel-nav button:hover { background:#f5f0e8; }
		
		.nnx-carousel {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
            scrollbar-width: none;
            padding-bottom: 4px;
        }
        .nnx-carousel::-webkit-scrollbar { display: none; }
        .nnx-citem {
            flex: 0 0 calc((100% - 64px) / 5);
            scroll-snap-align: start;
            text-align: left;
        }
        @media (max-width:900px){
            .nnx-citem { flex: 0 0 calc((100% - 32px) / 3); }
        }
        @media (max-width:600px){
            .nnx-citem { flex: 0 0 calc((100% - 16px) / 2); }
        }
		
		.nnx-citem img { width:100%; height:150px; object-fit:cover; border-radius:10px; margin-bottom:8px; }
		.nnx-citem h4 {
            font-size: 13px;
            margin: 4px 0 2px;
            font-weight: 500;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 34px;
        }
		.nnx-price { font-size:14px; font-weight:600; color:#8a6d3b; margin:0 0 8px; }
        .nnx-buy { display:block; width:100%; box-sizing:border-box; padding:8px 0; background:#7d8ca3; border-radius:20px; text-decoration:none; color:#fff; font-size:13px; text-align:center; }
        .nnx-buy:hover { background:#6b7a90; }
    </style>

    <script>
        function nnxScroll(id, dir) {
            document.getElementById(id).scrollBy({ left: dir * 200, behavior: 'smooth' });
        }
    </script>
    <?php
    return ob_get_clean();
}

// Thêm Giá + Nút Mua ngay vào mô tả ngắn trên trang Archive Sản phẩm
add_filter( 'the_excerpt', 'nnx_add_price_button_archive' );
function nnx_add_price_button_archive( $excerpt ) {

    if ( get_post_type() === 'san_pham_aff' && is_post_type_archive( 'san_pham_aff' ) ) {

        $gia  = get_post_meta( get_the_ID(), 'gia-tien', true );
        $link = get_post_meta( get_the_ID(), 'link-san-pham', true );

        $gia_html = $gia
            ? number_format( str_replace( '.', '', $gia ), 0, ',', '.' ) . 'đ'
            : 'Liên hệ';

        $url = $link ? $link : get_permalink();

        $html  = '<p class="nnx-archive-desc">' . $excerpt . '</p>';
        $html .= '<p class="nnx-archive-price">' . $gia_html . '</p>';
        $html .= '<a class="nnx-archive-buy" href="' . esc_url( $url ) . '" target="_blank" rel="nofollow noopener">Mua ngay</a>';

        return $html;
    }

    return $excerpt;
}

// Style cho phần Giá + Nút Mua ngay trên trang Archive
add_action( 'wp_head', 'nnx_archive_style' );
function nnx_archive_style() {
    if ( is_post_type_archive( 'san_pham_aff' ) ) {
        echo '<style>
            .nnx-archive-desc { color: #555; margin: 6px 0; }
            .nnx-archive-price { font-weight: 600; color: #8a6d3b; margin: 4px 0 8px; }
            .nnx-archive-buy {
                display: inline-block;
                padding: 8px 20px;
                background: #7d8ca3;
                color: #fff;
                border-radius: 20px;
                text-decoration: none;
                font-size: 14px;
            }
            .nnx-archive-buy:hover { background: #6b7a90; }
        </style>';
    }
}

// Thêm Giá + Nút Mua ngay vào trang chi tiết (single) Sản phẩm
add_filter( 'the_content', 'nnx_add_price_button_single' );
function nnx_add_price_button_single( $content ) {

    if ( is_singular( 'san_pham_aff' ) && in_the_loop() && is_main_query() ) {

        $link = get_post_meta( get_the_ID(), 'link-san-pham', true );

        $box = '<div class="nnx-single-box">';
        if ( $link ) {
            $box .= '<a class="nnx-single-buy" href="' . esc_url( $link ) . '" target="_blank" rel="nofollow noopener">Mua ngay</a>';
        }
        $box .= '</div>';

        $content = $content . $box;
    }

    return $content;
}

// Style cho box Giá + Nút Mua ngay trên trang chi tiết
add_action( 'wp_head', 'nnx_single_style' );
function nnx_single_style() {
    if ( is_singular( 'san_pham_aff' ) ) {
        echo '<style>
            .nnx-single-box {
                margin-top: 24px;
                text-align: left;
            }
            .nnx-single-buy {
                display: inline-block;
                padding: 12px 32px;
                background: #7d8ca3;
                color: #fff;
                border-radius: 24px;
                text-decoration: none;
                font-size: 15px;
                font-weight: 600;
            }
            .nnx-single-buy:hover { background: #6b7a90; }
        </style>';
    }
}

// Thêm nhãn Category phía trên tiêu đề bài viết trên trang Blog
add_action( 'astra_entry_content_before', 'nnx_category_badge_before_title', 5 );
function nnx_category_badge_before_title() {
    if ( is_home() || is_archive() ) {
        $categories = get_the_category();
        if ( ! empty( $categories ) ) {
            echo '<span class="nnx-cat-badge">' . esc_html( $categories[0]->name ) . '</span>';
        }
    }
}