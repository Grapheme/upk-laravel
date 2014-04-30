<?php

class I18nNewsMeta extends BaseModel {

	protected $guarded = array();

	protected $table = 'i18n_news_meta';

	public static $order_by = 'created_at DESC,updated_at DESC';

	public static $rules = array(
		#'title' => 'required',
		#'seo_url' => 'alpha_dash',
	);

}