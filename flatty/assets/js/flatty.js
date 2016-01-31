jQuery(document).ready(function($) {

    /* No custom menu? Style default */
    if ($('.navbar .menu').length>0) {
        $('.navbar .menu').addClass('collapse navbar-collapse').children('ul').addClass('nav navbar-nav');
        $('li.page_item_has_children').addClass('dropdown').children('a').addClass('dropdown-toggle').attr('data-toggle','dropdown').append(' <i class="icon-caret-down"></i>').next('ul').addClass('dropdown-menu');
    }

    /* Navbar Dropdowns */
    if ($('nav ul.navbar-nav').length>0) {
        /* Level 1 */
        $('nav ul.navbar-nav > li').each(function() {
            if ($(this).children().hasClass('sub-menu')) {
                $(this).addClass('dropdown');
                $(this).children('a').addClass('dropdown-toggle').attr('data-toggle','dropdown').append('&nbsp;<i class="icon-caret-down"></i>');
                $(this).children('ul').removeClass('sub-menu').addClass('dropdown-menu');
            }
        });

        /* Level 2 */
        $('nav ul.navbar-nav > li li').each(function() {
            if ($(this).children().hasClass('sub-menu')) {
                $(this).addClass('dropdown-submenu');
                $(this).children('ul').removeClass('sub-menu').addClass('dropdown-menu');
            }
        });
    }

    /* Add "form-control" class to form elements */
    if ($('textarea').length>0 || $('input[type="email"]').length>0 || $('select').length>0 || $('input[type="text"]').length>0) {
        $('textarea,input[type="email"],input[type="text"],select').addClass('form-control');
    }

    /* Comments pager buttons */
    if ($('.page-numbers').length>0) {
        $('.page-numbers').each(function(){
            $(this).addClass('btn btn-sm');
            if ($(this).hasClass('current')) $(this).addClass('btn-info').attr('disabled','disabled');
            else $(this).addClass('btn-default');
        });
    }

    /* Comments submit and respond buttons */
    if ($('#comment-submit').length>0) $('#comment-submit').addClass('btn btn-primary btn-lg');
    if ($('.comment-reply-link').length>0) $('.comment-reply-link').addClass('btn btn-primary btn-xs');

    /* Carousels */
    if ($('.carousel').length>0) $('.carousel').carousel({interval: 7000});

    // Adds thickbox class to WordPress default gallery images
    if ($('div.gallery .gallery-icon a').length>0) {
        $('div.gallery .gallery-icon a').each(function(){
            $(this).addClass('thickbox').attr('rel','attached-to-'+$(this).closest('article').attr('id').replace( /^\D+/g, ''));
        });
    }

    // Adds thickbox class to post images
    if ($('article.media a > img').length>0) $('article.media a:not(\'.media-object\') > img').addClass('img-thumbnail').parent().addClass('thickbox');

});