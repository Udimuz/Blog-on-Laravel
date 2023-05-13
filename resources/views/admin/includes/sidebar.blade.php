<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
<?php
    //$url = explode('/', $_SERVER['REQUEST_URI']);
    // Если запущено "http://127.0.0.1:8000/admin" то 2-го параметра не будет, тогда дадим ему значение "admin"
    //$link = $url[2] ?? "admin";
    $link = explode('/', $_SERVER['REQUEST_URI'])[2] ?? "admin";
    //dump(Route::current()->getName());
    //dump(Route::current()->getPrefix());
//	function link_extract($address) {
//		//$adr = route('admin.post.index');
//		return substr($address, strrpos($address, '/')+1);
//    }
    //dump(route('admin.main.index'));
	function link_collect($link, $address): void {
		$adr = route($address);
		$sublink = substr($adr, strrpos($adr, '/')+1);
		echo '<a href="'.$adr.'" class="nav-link'.(($link===$sublink)?" active":"").'">';
    }
	/*
	 <a href="{{ route('admin.post.index') }}" class="nav-link <?=$link=="posts"?"active":""?>">
     <a href="{{ route('admin.main.index') }}" class="nav-link <?=$link=="main"?"active":""?>">
	*/
?>
    <div class="sidebar">
        <ul class="pt-3 nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                    {{ link_collect($link, 'admin.main.index') }}
                    <i class="nav-icon fas fa-home"></i>
                    <p>Главная</p>
                </a>
            </li>
            <li class="nav-item">
                {{ link_collect($link, 'admin.user.index') }}
                    <i class="nav-icon fa-solid fa-users"></i>
                    <p>Пользователи</p>
                </a>
            </li>
            <li class="nav-item">
                {{ link_collect($link, 'admin.post.index') }}
                    <i class="nav-icon fa-solid fa-envelopes-bulk"></i>
                    <p>Сообщения <span class="badge badge-info right">{{ Dima::postsCount() }}</span></p>
                </a>
            </li>
            <li class="nav-item">
                {{ link_collect($link, 'admin.category.index') }}
                    <i class="nav-icon far fa-image"></i>
                    <p>Категории</p>
                </a>
            </li>
            <li class="nav-item">
                {{ link_collect($link, 'admin.tag.index') }}
                    <i class="nav-icon fas fa-tags"></i>
                    <p>Тэги</p>
                </a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar -->
</aside>
