<?php

class SystemModules {

	public static function getSidebarModules(){

		$start_page = AuthAccount::getStartPage();
		return array(
			$start_page =>array(trans('admin.dashboard'),'fa-home',''),
			#$start_page.'/pages' =>array(trans('admin.pages'),'fa-list-alt','pages'),
			$start_page.'/i18n_pages'=>array(trans('admin.i18n_pages'),'fa-list-alt','pages'),
			$start_page.'/galleries'=>array(trans('admin.galleries'),'fa-picture-o','galleries'),
			#$start_page.'/news'=>array(trans('admin.news'),'fa-calendar','news'),
			$start_page.'/i18n_news'=>array(trans('admin.i18n_news'),'fa-calendar','news'),
			$start_page.'/articles' =>array(trans('admin.articles'),'fa-file-text-o','articles'),
			$start_page.'/catalogs#'=>array(trans('admin.catalogs'),'fa-truck','catalogs',
				array(
					$start_page.'/catalogs'=>array(trans('admin.catalog'),'fa-truck','catalogs'),
					$start_page.'/catalogs/categories'=>array(trans('admin.categories'),'fa-list','categories'),
					$start_page.'/catalogs/products'=>array(trans('admin.products'),'fa-th-large','products'),
					$start_page.'/catalogs/manufacturers'=>array(trans('admin.manufacturers'),'fa-linux','manufacturers')
				)
			),
			$start_page.'/templates'=>array(trans('admin.templates'),'fa-edit','templates'),
			$start_page.'/users'=>array(trans('admin.users'),'fa-male','users'),
			$start_page.'/groups'=>array(trans('admin.groups'),'fa-shield','users'),
			$start_page.'/languages'=>array(trans('admin.languages'),'fa-comments-o','languages'),
			$start_page.'/settings'=>array(trans('admin.settings'),'fa-cog','settings'),
			$start_page.'/downloads'=>array(trans('admin.downloads'),'fa-cloud-upload','downloads'),
		);
	}

	/*
	| Функция возвращает всю запись о модуле.
	| Если Модуль не существует - возвращается TRUE, это нужно для возможности дальнейшей проверки на уровне ролей групп пользователей
	| Allow::valid_access()
	*/

	public static function getModules($name = NULL,$index = NULL){

		$modules = array(
			'seo'=>array(trans('modules.seo'),'fa-search','seo',FALSE),
			'pages'=>array(trans('modules.pages'),'fa-list-alt','pages',TRUE),
			'catalogs'=>array(trans('modules.catalogs'),'fa-truck','catalogs',FALSE),
			'news'=>array(trans('modules.news'),'fa-calendar','news',TRUE),
			#'i18n_news'=>array(trans('modules.i18n_news'),'fa-calendar','i18n_news',FALSE),
			'articles'=>array(trans('modules.articles'),'fa-file-text-o','articles',TRUE),
			'galleries'=>array(trans('modules.galleries'),'fa-picture-o','galleries',TRUE),
			'languages'=>array(trans('modules.languages'),'fa-comments-o','languages',TRUE),
			'templates'=>array(trans('modules.templates'),'fa-edit','templates',TRUE),
			'users'=>array(trans('modules.users'),'fa-male','users',TRUE),
			'downloads'=>array(trans('modules.downloads'),'fa-downloads','downloads',FALSE),
		);
		if(is_null($name)):
			return $modules;
		else:
			if(isset($modules[$name])):
				if(is_null($index)):
					return $modules[$name];
				elseif(isset($modules[$name][$index])):
					return $modules[$name][$index];
				endif;
			else:
				return TRUE;
			endif;
		endif;
	}
}