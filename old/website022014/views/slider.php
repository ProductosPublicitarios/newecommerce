					<div id="slideshow-holder">
                        <!--slideshow-holder-->
                        <a href="#" class="prev" style="z-index:20;">prev</a>
                        <a href="#" class="next" style="z-index:20;">next</a>
                        <ul class="btn-slide" style="z-index:20;">
                            <?php if(is_array($img_slider)){foreach($img_slider as $val){ ?>
                            <li>
                                <a href="#"></a>
                            </li>
                            <?php }} ?>
                        </ul>
                        <div id="slideshow-content">
                            <div class="slider">
                                <?php if(is_array($img_slider)){foreach($img_slider as $val){ ?>
                                <img src="images/slider/<?php echo $val; ?>" alt="" />
                                <?php }} ?>
                            </div>
                        </div>
                    </div><!-- slideshow-holder-->