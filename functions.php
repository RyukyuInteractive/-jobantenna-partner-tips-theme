<?php
//////////////////////////////////////////////////
//親テーマのCSSを読み込む
//////////////////////////////////////////////////
function fit_head_child() {
	if ( get_option('fit_seo_cssLoad') == "value2" && get_option('fit_seo_cssLoad-main')) {
		echo '<link class="css-async" rel href="'.get_template_directory_uri().'/style.css">'."\n";
	}else{
		echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/style.css">'."\n";
	}
	if (is_singular()){
		if ( get_option('fit_seo_cssLoad') == "value2" && get_option('fit_seo_cssLoad-content')) {
			echo '<link class="css-async" rel href="'.get_template_directory_uri().'/css/content.css">'."\n";
		}else{
			echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/css/content.css">'."\n";
		}
	}
}
add_action('wp_head', 'fit_head_child');



//////////////////////////////////////////////////
//下記ユーザーカスタマイズエリア
//////////////////////////////////////////////////

// 再利用ブロックへの遷移を管理画面メニューからできるようにする
add_action('admin_menu', function () {
    add_menu_page('再利用ブロック', '再利用ブロック', 'manage_options', 'edit.php?post_type=wp_block', '', 'dashicons-screenoptions', 26);
});

add_action('wp_enqueue_scripts', function(){
    // TailwindCSS
    if (!is_addmin()) {
        wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com', [], '', false);
	}
});

// attachmentがinheritなため
add_action('pre_get_posts', function ($wp_query) {
    if (!is_admin() && $wp_query->is_main_query() && !is_singular() && $wp_query->get('attachment_category')) {
        $wp_query->set('post_status', 'inherit');
    }
});

// admin barに資料DownloadPage linkを追加
add_action('admin_bar_menu', function (WP_Admin_Bar $admin_bar) {
    $admin_bar->add_menu([
        'id'    => 'document-download-page',
        'parent' => null,
        'group'  => null,
        'title' => '資料DonwloadPage',
        'href'  => '/partner-tips/attachment_category/document/',
    ]);
}, 99);
