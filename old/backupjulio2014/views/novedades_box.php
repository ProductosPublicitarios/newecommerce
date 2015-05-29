					<div class="left-bottom sub">
                        <div class="box">
                            <h4>Novedades</h4>
                            <?php if(is_array($arr_news)){foreach($arr_news['titulo'] as $k=>$v){ ?>
                            <div class="img">
                                <img src="images/productos/<?php echo $arr_news['uri'][$k]; ?>" alt="<?php echo $v; ?>" width="143" height="131" /><a href="ver.php?id=<?php echo $arr_news['id'][$k]; ?>" class="product iframe">&#8226; <?php echo $v; ?></a>
                            </div>
                            <?php }} ?>
                        </div>
                    </div>