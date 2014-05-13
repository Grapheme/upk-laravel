<?php

class I18nPageMeta extends BaseModel {

	protected $guarded = array();

	protected $table = 'i18n_pages_meta';

	public static $order_by = 'created_at DESC,updated_at DESC';

	public static $rules = array(
		#'title' => 'required',
		#'seo_url' => 'alpha_dash',
	);

}