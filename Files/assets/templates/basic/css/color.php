<?php
header("Content-Type:text/css");
$color1 = $_GET['color1']; // Change your Color Here

function checkhexcolor($color){
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color1']) AND $_GET['color1'] != '') {
    $color1 = "#" . $_GET['color1'];
}

if (!$color1 OR !checkhexcolor($color1)) {
    $color1 = "#336699";
}

?>

.custom-btn, .custom-btn:hover, .checkbox-wrapper .checkbox-item label a, .forgot-password a, .navbar-toggler span, .footer-bottom-area .copyright-area p a, .nav-tabs .nav-item .nav-link.active, .product-details-content .product-desc a, .product-single-tab .nav-tabs .nav-item .nav-link.active, .product-desc-content ul li i, .product-reviews-content .comment-box .ratings-container i, .contact-info-icon i, .blog-content .title a:hover, .category-content li:hover, .starrr a {
  color: <?= $color1 ?>;
}

.text--base{
  color: <?= $color1 ?> !important;
} 

.sidebar-home .widget, .side-menu-wrapper, .widget-box{
  box-shadow: 0px 0px 7px 0 <?= $color1 ?>70;
}

.scrollToTop, .pagination .page-item.active .page-link, .pagination .page-item:hover .page-link, .badge-circle, footer-bottom-area::after, .side-menu-title, .widget-range-title, .pagination .page-item.disabled span {
  background: <?= $color1 ?>;
}

.custom-table thead tr, *::-webkit-scrollbar-button, *::-webkit-scrollbar-thumb, .slider-next, .slider-prev, .tab-menu .nav-item.active, .btn--base, .submit-btn, .surface .coin, ::selection, .cart-dropdown .btn-remove, .header-bottom-area .navbar-collapse .main-menu li .sub-menu li::before, .tip-hot, .footer-social li:hover, .footer-ribon, .info-icon , .widget .ui-slider-range, .widget .ui-state-default, .account-tab .nav-tabs .nav-item .nav-link, .product-default .product-label.label-sale, .account-area .account-close, .blog-social-area .blog-social li:hover, .tag-item-wrapper .tag-item:hover, .input-group-text, .footer-bottom-area::after, .custom-check-group input:checked + label::before {
  background-color: <?= $color1 ?>;
}

.bg--base {
  background-color: <?= $color1 ?> !important;
}

.product-single-filter .config-size-list li.active a {
  border: 1px solid <?= $color1 ?>;
}

.tab-menu .nav-item.active, .profile-thumb-area .image-preview {
  border: 2px solid <?= $color1 ?>;
}

.section-header .section-title {
  border-bottom: 2px solid <?= $color1 ?>;
}

.pagination .page-item.active .page-link, .pagination .page-item:hover .page-link, .nav-tabs .nav-item .nav-link.active, .product-single-tab .nav-tabs .nav-item .nav-link.active  {
  border-color: <?= $color1 ?>;
}

.tip-hot:not(.tip-top):before {
  border-right-color: <?= $color1 ?>;
}

.footer-ribon::before {
  border-right: 15px solid <?= $color1 ?>;
}

.add-cart-box {
  border-top: 4px solid <?= $color1 ?>;
}

.account-area {
  border-top: 5px solid <?= $color1 ?>;
  border-bottom: 5px solid <?= $color1 ?>;
}


@media only screen and (max-width: 991px) {
  .custom-table tbody tr td::before {
    color: <?= $color1 ?>;
  }
}