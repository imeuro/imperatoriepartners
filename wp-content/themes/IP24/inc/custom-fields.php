<?php 
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_dettagli-scheda-immobile',
		'title' => 'Dettagli scheda immobile',
		'fields' => array (
			array (
				'key' => 'field_4fe46b8d15231',
				'label' => 'Locali',
				'name' => 'locali',
				'type' => 'select',
				'choices' => array (
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
					6 => 6,
					'7+' => '7+',
				),
				'default_value' => '',
				'allow_null' => 1,
				'multiple' => 0,
			),
			array (
				'key' => 'field_4fe46b8d15a52',
				'label' => 'Metri quadri',
				'name' => 'metriquadri',
				'type' => 'text',
				'default_value' => '',
				'formatting' => 'html',
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array (
				'key' => 'field_4fe46b8d161d2',
				'label' => 'Prezzo',
				'name' => 'prezzo',
				'type' => 'text',
				'default_value' => '',
				'formatting' => 'html',
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => '0',
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'discussion',
				1 => 'comments',
				2 => 'author',
				3 => 'format',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_dettagli-riservati',
		'title' => 'Dettagli Riservati',
		'fields' => array (
			array (
				'key' => 'field_4ff70fdc9113c',
				'label' => 'Info Riservate',
				'name' => 'info_riservate',
				'type' => 'wysiwyg',
				'toolbar' => 'basic',
				'media_upload' => 'no',
				'default_value' => '',
			),
			array (
				'key' => 'field_4ff70fdc91b3f',
				'label' => 'Immagini Riservate',
				'name' => 'immagini_riservate',
				'type' => 'image',
				'instructions' => 'Immagini Riservate: vengono visualizzate sul sito solo se loggati come utenti amministratori',
				'save_format' => 'id',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_4ff7124b35fcd',
				'label' => '',
				'name' => 'immagini_riservate2',
				'type' => 'image',
				'save_format' => 'id',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_4ff7124b36736',
				'label' => '',
				'name' => 'immagini_riservate3',
				'type' => 'image',
				'save_format' => 'id',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_4ff7124b36d2b',
				'label' => '',
				'name' => 'immagini_riservate4',
				'type' => 'image',
				'save_format' => 'id',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_4ff7124b37399',
				'label' => '',
				'name' => 'immagini_riservate5',
				'type' => 'image',
				'save_format' => 'id',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_4ff70fdc921d7',
				'label' => 'Documenti Riservati',
				'name' => 'documenti_riservati',
				'type' => 'file',
				'instructions' => 'Documenti Riservati: vengono visualizzati sul sito solo se loggati come utenti amministratori',
				'save_format' => 'id',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => '0',
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 1,
	));
}
?>