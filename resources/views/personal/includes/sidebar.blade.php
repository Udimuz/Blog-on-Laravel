<?php
$link = explode('/', $_SERVER['REQUEST_URI'])[2] ?? "personal";
function link_collect($link, $address): void {
	$adr = route($address);
	$sublink = substr($adr, strrpos($adr, '/')+1);
	echo '<a href="'.$adr.'" class="nav-link'.(($link===$sublink)?" active":"").'">';
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="pt-3 nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                {{ link_collect($link, 'personal.main.index') }}
                    <i class="nav-icon fas fa-home"></i>
                    <p>Главная</p>
                </a>
            </li>
            <li class="nav-item">
                {{ link_collect($link, 'personal.liked.index') }}
                    <i class="nav-icon far fa-heart"></i>
                    <p>Понравившиеся посты</p>
                </a>
            </li>
            <li class="nav-item">
                {{ link_collect($link, 'personal.comment.index') }}
                    <i class="nav-icon far fa-comment"></i>
                    <p>Комментарии</p>
                </a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar -->
</aside>
