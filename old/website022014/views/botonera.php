					<ul class="options">
                        <!--options-->
                        <?php
                        if(is_array($arr_categorias)){
							$i=1;
							foreach($arr_categorias as $key=>$value){ 
								if($i==$id_cat and $i==1){
									$class=' class="current first"';
								}elseif($i==1){
									$class=' class="first"';
								}elseif($i==$id_cat){
									$class=' class="current"';
								}else{
									$class='';
								}
								$i++;
						?>
                        <li<?php echo $class;?>>
                            <a href="productos.php?c=<?php echo $key; ?>"><?php echo $value; ?></a>
                  		</li>
                        <?php }} ?>
                    </ul>
                    <!-- end options-->