						<div class="products-wrapper">
                          <h5>Novedades</h5>
                            <ul class="product">
                              <?php if(is_array($arr_news)){foreach($arr_news['titulo'] as $k=>$v){ ?>
                              <li<?php echo $arr_news['class'][$k]; ?>><a href="ver.php?id=<?php echo $arr_news['id'][$k]; ?>" class="iframe"><img src="images/productos/<?php echo $arr_news['uri'][$k]; ?>" alt="<?php echo $v; ?>" width="122" height="121" /></a><a href="#" class="product" style="width:115px;">&#8226; <?php echo $v; ?></a></li>
                              <?php }} ?>
                            </ul>
                            <h5>Cat&aacute;logo</h5>
                            <ul class="product last">
                            	<?php if(is_array($arr_cat)){foreach($arr_cat['titulo'] as $k=>$v){ ?>
                            	<li<?php echo $arr_cat['class'][$k]; ?>><a href="ver.php?id=<?php echo $arr_cat['id'][$k]; ?>" class="iframe"><img src="images/productos/<?php echo $arr_cat['uri'][$k]; ?>" alt="<?php echo $v; ?>" width="122" height="121" /></a><a href="#" class="product" style="width:115px;">&#8226; <?php echo $v; ?></a></li>
                            	<?php }} ?>
                            </ul>
                        </div>
                        <!-- end products-wrapper-->