<?php

include_once(THEME_PHYSICAL_DIR . '/database/bl/attribute.php');
include_once(THEME_PHYSICAL_DIR . '/database/bl/items.php');
include_once(THEME_PHYSICAL_DIR . '/common-files/config.php');


global $languages;
global $attribute;
global $config_attribute_values;
$lang = get_site_lang();
$attribute_bl = new attribute_bl();
$continent_values = $attribute_bl->get_attribute_values_lang_by_attribute_id($attribute['continent'], $languages[$lang]);
$official_lang_values = $attribute_bl->get_attribute_values_lang_by_attribute_id($attribute['official-language'], $languages[$lang]);

?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 no-padding-right">
                <div class="project-heading base-margin-top-bottom">
                    <div>
                        <h3 class="base-margin-bottom">SEARCH</h3>
                        <input class="input keyword" placeholder="Country Name" type="text">

                        <div class="block-featured-tail clear-filter margin-right">
                            <a id="search_btn" href="javascript:void(0)" class="reduce-margin-left">Search</a>
                        </div>
                    </div>
                    <div class="base-margin-top-bottom">
                        <h3 class="base-margin-bottom">FILTERD BY :</h3>

                        <div class="filter white-bg">

                            <div class="type">
                                <p><i class="click fa fa-caret-down"></i>Continent</p>

                                <div class="toggle-div">
                                    <div class="checkbox">
                                        <input type="radio" name="continent" style="width: 10%" class="attr_val"
                                               value="">
                                        <span>All</span>
                                    </div>
                                    <?php foreach ($continent_values as $continent_value) { ?>
                                        <div class="checkbox">
                                            <input type="radio" name="continent" style="width: 10%" class="attr_val"
                                                   value="<?php echo $attribute['continent'] . ':' . $continent_value->id ?>"/>
                                            <span><?php echo $continent_value->attribute_value; ?></span>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="type">
                                <p><i class="click fa fa-caret-down"></i>Official Language</p>

                                <div class="toggle-div">
                                    <div class="checkbox">
                                        <input type="radio" name="language" style="width: 10%" class="attr_val"
                                               value="">
                                        <span>All</span>
                                    </div>
                                    <?php foreach ($official_lang_values as $official_lang_value) { ?>
                                        <div class="checkbox">
                                            <input type="radio" name="language" style="width: 10%" class="attr_val"
                                                   value="<?php echo $attribute['official-language'] . ':' . $official_lang_value->id ?>"/>
                                            <span><?php echo $official_lang_value->attribute_value; ?></span>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="type">
                                <p><i class="click fa fa-caret-down"></i>Landlocked</p>

                                <div class="toggle-div">
                                    <div class="checkbox">
                                        <input type="radio" name="land"
                                               style="width: 10%" class="attr_val" value=""/>
                                        <span>Any</span>
                                    </div>
                                    <div class="checkbox">
                                        <input type="radio" name="land" style="width: 10%" class="attr_val"
                                               value="<?php echo $attribute['landlocked'] . ':' . $config_attribute_values['false'] ?>"/>
                                        <span>No</span>
                                    </div>
                                    <div class="checkbox">
                                        <input type="radio" name="land" style="width: 10%" class="attr_val"
                                               value="<?php echo $attribute['landlocked'] . ':' . $config_attribute_values['true'] ?>"/><span>Yes</span>
                                    </div>
                                </div>
                            </div>
                            <div class="type">
                                <p><i class="click fa fa-caret-down"></i>GDP</p>

                                <div class="toggle-div">
                                    <input id="gdp" type="hidden" value="<?php echo $attribute['gdp'] ?>">
                                    <label>From<input id="from" type="text"/></label>
                                    <label>To<input id="to" type="text"/></label>
                                </div>
                            </div>
                            <br/><br/>

                        </div>
                        <div class="block-featured-tail clear-filter margin-right">
                            <a href="#" class="reduce-margin-left">Clear Filters</a>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-lg-9">
                <div class="">
                    <div class="project-heading row base-margin-top-bottom">
                        <div class="col-lg-12">
                            <div class="col-lg-12 hidden-xs">
                                <p><span class="head">Countries </span>Display 1 - 8 results</p>
                                <input id="count" type="hidden" value="2">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="items">
                </div>
            </div>
            <div class="base-margin-top-bottom row">
                <div class="col-lg-3">

                </div>
                <div class="col-lg-3">

                </div>
                <div class="col-lg-3">
                    <a href="javascript:void(0)" class="load-more">Load More</a>
                </div>
                <div class="col-lg-3">

                </div>
            </div>
        </div>
    </div>
</section>
<script>
    on_load = true;
    items_per_page = 2;
    $(document).ready(function () {
        $(".click").click(function () {
            $(this).parent().next(".toggle-div").toggle();
        });

        $(window).bind('load', function () {
//        var full_url = decodeURIComponent(window.location.href);
//            var full_url = window.location.href;
//            full_url = full_url.split('/');
//            params = full_url[5].split('&');
//            console.log(params.length);
//            if (params.length > 1) {
//                $('#count').val(params[3]);
            get_search_results();
//            } else {
//                $('#count').val(page_count);
//                get_search_results(null, null, null, 0, page_count, '2');
//            }
        });
    });
    function get_search_attributes() {
        attributes = '';
        $('.attr_val:checked').each(function () {
            if ($(this).val())
                attributes += $(this).val() + '|';
        });
        attributes = attributes.substring(0, attributes.length - 1);
        return attributes;
    }
    function get_search_keyword() {
        return $('.keyword').val();
    }
    function get_search_range() {
        return $('#gdp').val() + ':' + $('#from').val() + ',' + $('#to').val();
    }
    function get_search_results() {
        var data;
        var full_url = window.location.href;
        var full_url = window.location.href;
        full_url = full_url.split('/');
        params = full_url[5].split('&');
        if (!(params.length > 1)) {
            new_params = '?keyword=' + get_search_keyword() +
            '&attributes=' + get_search_attributes() + '&range=' + get_search_range() +
            '&page_from=' + 0;
            window.history.pushState({path: new_params}, '', new_params);
            data = {
                action: 'search',
                keyword: get_search_keyword(),
                attributes: get_search_attributes(),
                attributes_range: get_search_range(),
                page_from: 0,
                page_count: items_per_page
            };
        } else {
            if (on_load) {
                data = {
                    action: 'search',
                    keyword: GetQueryStringParams('keyword'),
                    attributes: GetQueryStringParams('attributes'),
                    attributes_range: GetQueryStringParams('range'),
                    page_from: 0,
                    page_count: (items_per_page + parseInt(GetQueryStringParams('page_from')))
                }
            } else {
                data = {
                    action: 'search',
                    keyword: GetQueryStringParams('keyword'),
                    attributes: GetQueryStringParams('attributes'),
                    attributes_range: GetQueryStringParams('range'),
                    page_from: GetQueryStringParams('page_from'),
                    page_count: items_per_page
                }
            }
        }
        ajax_url = '/ajax-handler/';
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (response) {
                var result = $.parseJSON(response);
                if (result) {
                    $('#items').append(result);
                    $('.load-more').show();
                }
                else
                    $('.load-more').hide();
            }
        });
    }
    function GetQueryStringParams(sParam) {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam) {
                return sParameterName[1];
            }
        }
    }

    $(document).on('click', '#search_btn', function () {
        on_load = false;
        $('#items').html('');
        $('#count').val(items_per_page);
        window.history.pushState({path: '?'}, '', '?');
        get_search_results();
    });
    $(document).on('click', '.load-more', function () {
        on_load = false;
        new_params = '?keyword=' + GetQueryStringParams('keyword') +
        '&attributes=' + GetQueryStringParams('attributes') + '&range=' + GetQueryStringParams('range') +
        '&page_from=' + (parseInt(GetQueryStringParams('page_from')) + 2);
        window.history.pushState({path: new_params}, '', new_params);
        get_search_results();
        $('#count').val(parseInt($('#count').val()) + items_per_page);
    });
</script>
