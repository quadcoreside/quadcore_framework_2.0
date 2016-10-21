<?php
Router::prefix('admin', 'admin');

Router::connect('','home/index');
Router::connect('admin','admin/home/index');

Router::connect('pages/:slug', 'pages/view/slug:([a-z0-9\-]+)');
Router::connect('pages/:slug', 'pages/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
