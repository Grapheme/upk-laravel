<?php

class I18nNews extends BaseModel {

	protected $guarded = array();

	protected $table = 'i18n_news';

	public static $order_by = 'id DESC';

	public static $rules = array(
		#'news_ver_id' => 'required',
		#'seo_url' => 'alpha_dash',
	);

}