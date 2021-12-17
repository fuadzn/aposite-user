<?php
function buildMenu(){ 
	$menu = '';
	$menu_other_header = '';
	$menu_other_body = '';
	$menu_other_footer = '';
	$CI =& get_instance();    
	$CI->load->model('admin/M_menu','',TRUE);
	
	$datas = $CI->M_menu->get_allowed_menu(0);
	
	$class_beranda = "";

	$i=1;
	foreach($datas->result() as $data){
		$class_active = "";
		$uri_1 = $CI->uri->segment(1); 
		$uri_2 = $CI->uri->segment(2); 
		if($uri_2==""){
			$uri_all = $uri_1;
		}else{
			$uri_all = $uri_1.'/'.$uri_2;
		}
		
		if($uri_1=='beranda'){
			$page_set = 0;
			$class_beranda = 'class="active"';
		}else{
			$page_set = $CI->M_menu->get_page_set($uri_all)->row()->page_parent;
		}

		if($i>5){
			$menu_other_header = '<li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="feather icon-more-horizontal"></i><span data-i18n="Others">Others</span></a>
                        <ul class="dropdown-menu">';
			if ($data->is_parent == 0){
				if($page_set == $data->page_id){
					$class_active = 'class="active"';
				}
				$menu_other_body.= '
			        <li '.$class_active.' data-menu="">
	                  	<a class="dropdown-item" href="'.site_url($data->url).'" data-i18n="'.$data->title.'"><i class="'.$data->icon.'"></i>'.$data->title.'</a>
	                </li>
	                ';
			}else{
				if($page_set == $data->page_id){
					$class_active = 'active';
				}

				$menu_other_body.= '
				<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
					<a class="dropdown-toggle nav-link" href="javascript:;" data-toggle="dropdown">
						<i class="'.$data->icon.'"></i>
						<span data-i18n="'.$data->title.'">'.$data->title.'</span>
					</a>
					<ul class="dropdown-menu">';
				$datasc = $CI->M_menu->get_allowed_menu($data->page_id);
				foreach($datasc->result() as $datac)
				{
					$subclass_active = "";
					if($datac->url==$uri_all){
						$subclass_active = 'class="active"';
					}
					$menu_other_body.='
						<li '.$subclass_active.' data-menu="">
							<a class="dropdown-item" href="'.site_url($datac->url).'" data-toggle="dropdown" data-i18n="'.$datac->title.'">
							<i class="'.$datac->icon.'"></i>'.$datac->title.'
							</a>
                        </li>';
				}
				$menu_other_body.=	'	
						</ul>';
				$menu_other_body.= '
					</li>';
			}
			$menu_other_footer = '
					</ul>
				</li>';
		}else{
			if ($data->is_parent == 0){
				if($page_set == $data->page_id){
					$class_active = 'class="active"';
				}
				$menu.= '
			        <li '.$class_active.' data-menu="">
	                  	<a class="dropdown-item" href="'.site_url($data->url).'" data-i18n="'.$data->title.'"><i class="'.$data->icon.'"></i>'.$data->title.'</a>
	                </li>
	                ';
			}else{
				if($page_set == $data->page_id){
					$class_active = 'active';
				}

				$menu.= '
				<li class="dropdown nav-item" data-menu="dropdown">
					<a class="dropdown-toggle nav-link" href="javascript:;" data-toggle="dropdown">
						<i class="'.$data->icon.'"></i>
						<span data-i18n="'.$data->title.'">'.$data->title.'</span>
					</a>
					<ul class="dropdown-menu">';
				$datasc = $CI->M_menu->get_allowed_menu($data->page_id);
				foreach($datasc->result() as $datac)
				{
					$subclass_active = "";
					if($datac->url==$uri_all){
						$subclass_active = 'class="active"';
					}
					$menu.='
		              	<li '.$subclass_active.' data-menu="">
							<a class="dropdown-item" href="'.site_url($datac->url).'" data-toggle="dropdown" data-i18n="'.$datac->title.'">
								<i class="'.$datac->icon.'"></i>'.$datac->title.'
							</a>
						</li>';
				}
				$menu.=	'	
						</ul>';
				$menu.= '
					</li>';
			}

		}
		$i++;
	}

	$menu_beranda='
		        <li '.$class_beranda.' data-menu="">
                  	<a class="dropdown-item" href="'.site_url("beranda").'" data-i18n="Beranda"><i class="feather icon-home"></i>Beranda</a>
                </li>
                ';
	
	return $menu_beranda.$menu.$menu_other_header.$menu_other_body.$menu_other_footer;
}

function buildBreadcrumb($title=""){
	$CI =& get_instance();    
	$CI->load->model('admin/M_menu','',TRUE);
	$uri_1 = $CI->uri->segment(1); 
	$uri_2 = $CI->uri->segment(2); 

	$url = $CI->uri->uri_string();
	$out = "";
	if($uri_1=='beranda'){
		// $out .= '<h2 class="content-header-title float-left mb-0">Beranda</h2>';
	}else{
		// $out .= '<h2 class="content-header-title float-left mb-0">'.$title.'</h2>';
		$datas = $CI->M_menu->get_breadcrumb($uri_1.'/'.$uri_2);
		foreach($datas->result() as $data){
			if ($data->parent_id != 0){
				$out.= '<div class="d-flex justify-content-end breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                            	<ol class="breadcrumb mr-1">
                            		<li class="breadcrumb-item">'.$data->ptitle.'</li>
	                                <li class="breadcrumb-item active" aria-current="page"><a href="'.site_url($uri_1.'/'.$uri_2).'">'.$data->title.'</a></li>
                            	</ol>
                            </nav>
                        </div>';
			}
		}
	}
	return $out;
}

function sortMenu(){
	$menu = '';
	$CI =& get_instance();    	
	$CI->load->model('admin/M_menu','',TRUE);
	$datas = $CI->M_menu->get_child(0);
	
	foreach($datas->result() as $data)
	{
		$menu.= '
				<div class="card collapse-header dt-module__content-inner" id="id_'.$data->page_id.'">
				    <div id="heading'.$data->page_id.'" class="card-header collapse-header" data-toggle="collapse" role="button" data-target="#accordion'.$data->page_id.'" aria-expanded="false" aria-controls="accordion'.$data->page_id.'">
				        <span class="lead collapse-title">
				            '.$data->title.'
				        </span>
                        <span class="pull-right" style="margin-right: 20px">
							<a href="#" title="Edit" onClick="return editMenu('.$data->page_id.');" class="btn btn-icon btn-primary"><i class="feather icon-edit"></i></a> 
							<a href="#" title="Hapus" onClick="return dropMenu('.$data->page_id.');" class="btn btn-icon btn-danger"><i class="feather icon-trash"></i></a>
                        </span>
				    </div>
					';
		if ($data->is_parent == 1){
			$menu.= '
				    <div id="accordion'.$data->page_id.'" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading'.$data->page_id.'" class="collapse">
                        <ul class="list-group sortable">';
			$datasc = $CI->M_menu->get_child($data->page_id);
			foreach($datasc->result() as $datac)
			{
				$menu.='
                        <li class="list-group-item d-flex justify-content-between align-items-center" id="id_'.$datac->page_id.'">
                            <span>'.$datac->title.'</span>
                            <span class="pull-right">
                            <a href="#" title="Edit" onClick="return editMenu('.$datac->page_id.');" class="btn btn-icon btn-primary"><i class="feather icon-edit"></i></a> 
								<a href="#" title="Hapus" onClick="return dropMenu('.$datac->page_id.');" class="btn btn-icon btn-danger"><i class="feather icon-trash"></i></a>
							</span>
                        </li>';
			}
			$menu.= '	</ul>
					 </div>';
		}
		$menu.= '</div>';
	}
	
	return $menu;
}
// <div class="card collapse-header">
//     <div id="heading1" class="card-header collapse-header" data-toggle="collapse" role="button" data-target="#accordion1" aria-expanded="false" aria-controls="accordion1">
//         <span class="lead collapse-title">
//             Accordion Item 1
//         </span>
//     </div>
//     <div id="accordion1" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading1" class="collapse">
//         <div class="card-content">
//             <div class="card-body">
//                 Cheesecake cotton candy bonbon muffin cupcake tiramisu croissant. Tootsie roll sweet candy bear
//                 claw chupa chups lollipop toffee. Macaroon donut liquorice powder candy carrot cake macaroon
//                 fruitcake. Cookie toffee lollipop cotton candy ice cream dragée soufflé.

//                 Cake tiramisu lollipop wafer pie soufflé dessert tart. Biscuit ice cream pie apple pie topping
//                 oat cake dessert. Soufflé icing caramels. Chocolate cake icing ice cream macaroon pie cheesecake
//                 liquorice apple pie.
//             </div>
//         </div>
//     </div>
// </div>

function sortMenu2()
{
	$menu = '';
	$CI =& get_instance();    	
	$CI->load->model('admin/M_menu','',TRUE);
	$datas = $CI->M_menu->get_child(0);
	
	foreach($datas->result() as $data)
	{
		$menu.= '<div class="s_panel" id="id_'.$data->page_id.'">
					<div class="h3">'.$data->title.'
						<span class="pull-right">
						<a href="#" title="Edit" onClick="return editMenu('.$data->page_id.');"><i class="fa fa-edit fa-fw"></i></a>
						&nbsp;
						<a href="#" title="Hapus" onClick="return dropMenu('.$data->page_id.');"><i class="fa fa-trash fa-fw"></i></a>
						</span>
					</div>';
		if ($data->is_parent == 1){
			$menu.= '<div>';
			$menu.= '	<ul class="sortable">';
			$datasc = $CI->M_menu->get_child($data->page_id);
			foreach($datasc->result() as $datac)
			{
				$menu.='<li class="ui-state-default" id="id_'.$datac->page_id.'"><span class="ui-icon ui-icon-arrowthick-2-n-s pull-left"></span>'.$datac->title.'
							<span class="pull-right">
								<a href="#" title="Edit" onClick="return editMenu('.$datac->page_id.');"><i class="fa fa-edit fa-fw"></i></a>
								&nbsp;
								<a href="#" title="Hapus" onClick="return dropMenu('.$datac->page_id.');"><i class="fa fa-trash fa-fw"></i></a>
							</span>
						</li>';
			}
			$menu.= '	</ul>
					 </div>';
		}
		$menu.= '</div>';
	
	}
	
	return $menu;
}
?>