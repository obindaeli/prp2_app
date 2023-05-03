<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Progress Report Pengendalian Pembangunan Nias Barat</title>
    <meta name="description" content="Progress Report Pengendalian Pembangunan Nias Barat" />
    <meta name="keywords" content="aplikasi,Nias Barat,pengendalian,pembangunan,report" />
    <meta name="author" content="Progress Report Pengendalian Pembangunan Nias Barat" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="all,follow">

    <!-- Fonts and icons -->
    <script src="<?= base_url(); ?>assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ['<?= base_url(); ?>assets/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/atlantis.min.css">
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/datepicker/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/default.css">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('images/logo_niasbarat.png'); ?>">
</head>

<body style="overflow-y:scroll;">
    <div class="wrapper">
        <?php $user = detail_user(); ?>
        <?php $this->load->view("_partial/navbar", $user); ?>
        <?php $this->load->view("_partial/sidebar", $user); ?>
        <div class="main-panel">
            <div class="content">
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>