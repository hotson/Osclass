<?php
/*
 *      OSCLass – software for creating and publishing online classified
 *                           advertising platforms
 *
 *                        Copyright (C) 2010 OSCLASS
 *
 *       This program is free software: you can redistribute it and/or
 *     modify it under the terms of the GNU Affero General Public License
 *     as published by the Free Software Foundation, either version 3 of
 *            the License, or (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful, but
 *         WITHOUT ANY WARRANTY; without even the implied warranty of
 *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *             GNU Affero General Public License for more details.
 *
 *      You should have received a copy of the GNU Affero General Public
 * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>
<?php
    $item = $this->_get('item') ;
    $author = $this->_get('author') ;
    $comments = $this->_get('comments') ;
    $resources = $this->_get('resources') ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
    <head>
        <?php $this->osc_print_head() ; ?>
    </head>
    <body>
        <div class="container">
            <?php $this->osc_print_header() ; ?>
            
            <div id="form_publish">
                <?php include("inc.search.php") ; ?>
                <strong class="publish_button"><a href="<?php echo osc_item_post_url(osc_item_category_id($item)) ; ?>"><?php _e("Publish your ad for free") ; ?></a></strong>
            </div>

            <div class="content item">
                <div id="item_head">
                    <div class="inner">
                        <h1><span class="price"><?php echo osc_format_price($item) ; ?></span> <strong><?php echo osc_item_title($item) ; ?></strong></h1>

                        <p id="report">
                            <strong><?php _e('Mark as ') ; ?></strong>
                            <span>
                                <a id="item_spam" href="<?php echo osc_item_link_spam($item) ; ?>"><?php _e('spam') ; ?></a>
                                <a id="item_bad_category" href="<?php echo osc_item_link_bad_category($item) ; ?>"><?php _e('bad category') ; ?></a>
                                <a id="item_repeated" href="<?php echo osc_item_link_repeated($item) ; ?>"><?php _e('repeated') ; ?></a>
                                <a id="item_expired" href="<?php echo osc_item_link_expired($item) ; ?>"><?php _e('expired') ; ?></a>
                                <a id="item_offensive" href="<?php echo osc_item_link_offensive($item) ; ?>"><?php _e('offensive') ; ?></a>
                            </span>
                        </p>
                    </div>
                </div>

                <div id="main">

                    <div id="type_dates">
                        <strong><?php echo osc_item_category($item) ; ?></strong>
                        <em class="publish"><?php echo date("d/m/Y", strtotime(osc_item_pub_date($item))) ; ?></em>
                        <em class="update"><?php echo date("d/m/Y", strtotime(osc_item_mod_date($item))) ; ?></em>
                    </div>

                    <ul id="item_location">
                        <?php if ( osc_item_country($item) != "" ) { ?><li><?php _e("Country:") ; ?> <strong><?php echo osc_item_country($item) ; ?></strong></li><?php } ?>
                        <?php if ( osc_item_region($item) != "" ) { ?><li><?php _e("Region:") ; ?> <strong><?php echo osc_item_region($item) ; ?></strong></li><?php } ?>
                        <?php if ( osc_item_city($item) != "" ) { ?><li><?php _e("City:") ; ?> <strong><?php echo osc_item_city($item) ; ?></strong></li><?php } ?>
                        <?php if ( osc_item_city_area($item) != "" ) { ?><li><?php _e("City area:") ; ?> <strong><?php echo osc_item_city_area($item) ; ?></strong></li><?php } ?>
                        <?php if ( osc_item_address($item) != "" ) { ?><li><?php _e("Address:") ; ?> <strong><?php echo osc_item_address($item) ; ?></strong></li><?php } ?>
                    </ul>

                    <div id="description">
                        <?php 
                        $locales = Locale::newInstance()->listAllEnabled() ;
                        if(count($locales) == 1 ) { ?>

                            <?php $locale = $locales[0] ; ?>
                            <p><?php echo  osc_item_description($item, $locale['pk_c_code']); ?></p>
                        
                        <?php } else {?>

                            <?php foreach($locales as $locale) { ?>
                                <h3><?php echo $locale['s_name']; ?>:</h3>
                                <?php echo  osc_item_description($item, $locale['pk_c_code']) ; ?>
                            <?php } ?>

                        <?php } ?>

                        <p class="contact_button">
                            <strong><a href="#contact"><?php _e('Contact publisher') ; ?></a></strong>
                        </p>
                    </div>

                    <!-- plugins -->
                    <?php osc_run_hook('item_detail', $item) ; ?>
                    <?php osc_run_hook('location') ; ?>


                    <?php if(osc_comments_enabled()) { ?>
                        <div id="comments">
                            <h2><?php _e('Comments'); ?></h2>
                            <?php if(isset($comments) && count($comments) > 0) { ?>
                                <div class="comments_list">
                                    <?php foreach($comments as $c) { ?>
                                        <div class="comment">
                                            <h3><strong><?php echo osc_comment_title($c) ; ?></strong> <em><?php _e("by") ; ?> <?php echo osc_comment_author_name($c) ; ?>:</em></h3>
                                            <p><?php echo osc_comment_author_email($c) ; ?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <form action="<?php echo osc_base_url(true) ; ?>" method="post">
                            <fieldset>
                                <h3><?php _e('Leave your comment (spam and offensive messages will be removed)') ; ?></h3>
                                <input type="hidden" name="action" value="add_comment" />
                                <input type="hidden" name="page" value="item" />
                                <input type="hidden" name="id" value="<?php echo osc_item_id($item) ; ?>" />
                                <label for="authorName"><?php _e('Your name:') ; ?></label> <input type="text" name="authorName" id="authorName" /><br />
                                <label for="authorEmail"><?php _e('Your email:') ; ?></label> <input type="text" name="authorEmail" id="authorEmail" /><br />
                                <label for="title"><?php _e('Title:') ; ?></label><br /><input type="text" name="title" id="title" /><br />
                                <label for="body"><?php _e('Comment:') ; ?></label><br /><textarea name="body" id="body" rows="5" cols="40"></textarea><br />
                                <button type="submit"><?php _e('Send comment') ; ?></button>
                            </fieldset>
                            </form>
                        </div>
                    <?php } ?>

                    <div id="useful_info">
                        <h2><?php _e('Helpful information') ; ?></h2>
                        <ul>
                            <li><?php _e('Avoid scams by dealing locally or paying with PayPal') ; ?></li>
                            <li><?php _e('Never pay with Western Union, Moneygram or other anonymous payment services') ; ?></li>
                            <li><?php _e("Don't buy or sell outside of your country. Don't accept cashier cheques from outside your country") ; ?></li>
                            <li><?php _e('This site is never involved in any transaction, and does not handle payments, shipping, guarantee transactions, provide escrow services, or offer "buyer protection" or "seller certification"') ; ?></li>
                        </ul>
                    </div>
                </div>

                <div id="sidebar">
                    <div id="photos">
                        <?php if(count($resources)) { ?>
                            <?php foreach($resources as $resource) { ?>
                                <img src="<?php echo osc_resource_url($resource) ; ?>" width="350" />
                            <?php } ?>
                        <?php } ?>

                    </div>

                    <div id="contact">
                        <h2><?php _e("Contact publisher");?></h2>
                        <form action="<?php echo osc_base_url(true) ; ?>?page=item" method="post" onsubmit="return validate_contact();">
                            <fieldset>
                                <h3><?php echo osc_user_name($author) ; ?></h3>
                                <?php if ( osc_user_phone($author) != '' ) { ?>
                                    <p class="phone"><?php _e("Tel.: ") ; ?> <?php echo osc_user_phone($author); ?></p>
                                <?php } ?>
                                <label for="yourName"><?php _e('Your name') ; ?> <?php _e('(optional)') ; ?>:</label><input type="text" name="yourName" value="" id="yourName" />
                                <label for="yourEmail"><?php _e('Your email address') ; ?>:</label><input type="text" name="yourEmail" value="" id="yourEmail" />
                                <label for="phoneNumber"><?php _e('Phone number') ; ?>:</label><input type="text" name="phoneNumber" value="" id="phoneNumber" />
                                <label for="message"><?php _e('Message') ; ?>:</label><textarea name="message" rows="8" cols="30"></textarea>
                                <input type="hidden" name="action" value="contact_post" />
                                <input type="hidden" name="id" value="<?php echo osc_item_id($item) ; ?>" />
                                <button type="submit"><?php _e('Send message') ; ?></button>
                            </fieldset>
                        </form>
                    </div>

                    <script type="text/javascript">
                        function validate_contact() {
                            email = $("#yourEmail");

                            var pattern=/^([a-zA-Z0-9_\.-])+@([a-zA-Z0-9_\.-])+\.([a-zA-Z])+([a-zA-Z])+/;
                            var num_error = 0;

                            if(!pattern.test(email.value)){
                                email.css('border', '1px solid red');
                                num_error = num_error + 1;
                            }

                            if(message.val().length < 1) {
                                message.css('border', '1px solid red');
                                num_error = num_error + 1;
                            }

                            if(num_error > 0) {
                                return false;
                            }

                            return true;
                        }
                    </script>

                    <!--
                    VER QUE HACEMOS CON ESTO    
                    <div id="item_contact_seller"><a href="<?php echo WEB_PATH; ?>/item.php?action=contact&amp;id=<?php echo $item['pk_i_id']; ?>"><?php echo __('Contact seller'); ?></a></div>
                    <div id="item_send_friend"><a href="<?php echo WEB_PATH; ?>/item.php?action=send_friend&amp;id=<?php echo $item['pk_i_id']; ?>"><?php echo __('Send to a friend'); ?></a></div>
                    -->
                </div>
            </div>
        </div>
        <?php $this->osc_print_footer() ; ?>
    </body>
</html>
