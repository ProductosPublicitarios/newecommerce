					<div class="product-sub">
                        <!--products-sub-->
                        <h5><?php echo $cat; ?><span style="font-size:12px;"><?php echo $subcats; ?></span></h5>
                        <ul>
                        	<?php $i=$j=0; if(is_array($arr_cat['titulo']) ){ foreach($arr_cat['titulo'] as $k=>$v){ 
								if( $i >= PROD_PER_ROW ){
									$i = 0;
									echo "</ul><ul>";
								}
							?>
                            <li>
								<img class="line" src="images/line.jpg" alt=""/>
                                <a class="iframe" href="ver.php?id=<?php echo $arr_cat['id'][$k]; ?>"><img src="images/productos/<?php echo $arr_cat['uri'][$k]; ?>" alt="<?php echo $v; ?>" style="max-width:120px;" /></a>
                                <ul class="sub">
                                    <li>
                                        <a href="ver.php?id=<?php echo $arr_cat['id'][$k]; ?>" class="product iframe">&#8226; <?php echo $v; ?></a>
                                    </li>
                                    <!--li>
                                        <a href="#" onClick="addCart(<?php echo $arr_cat['id'][$k]; ?>)" class="add">Agregar al carro de cotización</a>
                                    </li-->
                                </ul>
                            </li>
                            <?php $i++;$j++;}}else{	?>
                            <li>
                                <a href="#" class="product" style="width:500px;">&#8226; No se encontraron productos.</a>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php if($HAY_MAS or $HAY_MENOS){ ?>
                        <span>&nbsp;</span>
                        <?php } ?>
                        <?php if($HAY_MAS){ ?>
							<?PHP if($id_sub != 0){ ?>
	                            <a href="buscador.php?w=<?php echo $_GET['w']; ?>&p=<?php echo ($page_actual+1); ?>" class="next-light"> Siguiente</a>
                            <?PHP }else{ ?>
                            	<a href="buscador.php?w=<?php echo $_GET['w']; ?>&p=<?php echo ($page_actual+1); ?>" class="next-light"> Siguiente</a>
                            <?php } ?>
                        <?php } ?>
                        <?php if($HAY_MENOS){ ?>
                        	<?PHP if($id_sub != 0){ ?>
                            	<a href="buscador.php?w=<?php echo $_GET['w']; ?>&p=<?php echo ($page_actual-1); ?>" class="prev-light"> Anterior</a>
                            <?PHP }else{ ?>
                            	<a href="buscador.php?w=<?php echo $_GET['w']; ?>&p=<?php echo ($page_actual-1); ?>" class="prev-light"> Anterior</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <!--end products-sub-->