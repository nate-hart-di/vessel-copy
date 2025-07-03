<div id="main-navbar" class="navbar flex">
	<div class="navbar-inner">
		<div class="nav_section">
			<ul id="menu-top-menu" class="nav">
				<?php
				$items = wp_get_nav_menu_items('main-menu');
				foreach($items as $i => $menu_item) {
					$class = $menu_item->classes['0'];
                    $link_target = '_self';
                    $target = $menu_item->$target;
                    if( !empty($target && $target != '' ) ){
                        if( array_key_exists('_menu_item_target', $target) ){
                            $link_target = $target['_menu_item_target'][0];
                        }
                    }
				?>
				<li class="menu-item">
                    <a trid="0d3d5af3d8d1481fb671c9" trc <?php if($class == '' || in_array("hide-submenu", $menu_item->classes)) : ?>href="<?= $menu_item->url ?>"<?php endif; ?> target="<?php echo $link_target;?>" ><?= $menu_item->attr_title != '' ? str_replace(" Vehicles", "", $menu_item->attr_title) : str_replace(" Vehicles", "", $menu_item->title); ?></a>
					<?php if($class != '' || in_array("hide-submenu", $menu_item->classes)) : ?>
					
                    <div class="header-dropdown dropdown-full <?php echo $class;?>">
						<div class="header-dropdown-container">
							<div class="menu-navigation">

								<h2> <?= $menu_item->attr_title != '' ? $menu_item->attr_title : $menu_item->title; ?> </h2>
								<?php if (is_active_sidebar($class.'-menu-sidebar')) {
									dynamic_sidebar( ucfirst($class).' Menu Sidebar' );
								} ?>
							</div>

							<div class="menu-image-sidebar">
								<?php

					$menuad = get_field($class . '_menu_ad', 3);
					$menuadlink = get_field($class . '_menu_ad_link', 3);

					if(!empty($menuad)): ?>

								<a trid="018d53e8889a42f98a88f1" trc href="<?php echo $menuadlink; ?>">
									<img data-original="<?php echo $menuad['url']; ?>" alt="<?php echo $menuad['alt']; ?>" />
								</a>

							<?php endif; ?>
							</div>
						</div>
					</div>
					<?php endif; ?>
				</li>
			<?php } ?>
			</ul>
		</div>

	</div>
</div>