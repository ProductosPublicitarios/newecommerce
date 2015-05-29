				<div class="box-sidebar add">
                    <ul id="carrito">
                        <li style="margin-top:10px;margin-bottom:10px;">
                            <strong>Items</strong>
                        </li>
                        <?php if( count($_SESSION['prods']) <=1 ){ ?>
                        <li id="p_0">
                            0 items
                        </li>
                        <?php }else{ foreach($_SESSION['prods'] as $k=>$v){ if($v!=0){ 
						?>
                        <li id="p_<?php echo $k; ?>">
                           <?php echo $_SESSION['prods_name'][$k]. ': '.$v.'<a href="#" onclick="removeProd('.$k.')">[X]</a>'; ?>
                        </li>
                        <?php }}} ?>
                    </ul>
                    <?php if( count($_SESSION['prods']) >1 ){ ?>
                    <a id="btn-cotizar" href="cotizar.php" class="btn-add iframex"></a>
                    <?php }else{ ?>
                    <a id="btn-cotizar" href="cotizar.php" class="btn-add iframex" style="display:none;"></a>
                    <span>&nbsp;</span>
                    <?php } ?>
                </div>