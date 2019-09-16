<?php

    HTML::macro('breadcrumb', function($arr){
		
		$html = '';
		if(!count($arr)) return $html;

        $html .= '<ul class="page-breadcrumb breadcrumb">';
        $html .= '<li><a href="">Dashboard</a><i class="fa fa-circle"></i></li>';
        $html .=   '<li>';
        foreach ($arr as $route_name => $name) {
        	if($route_name) {
				$html .= '<a href="'.route($route_name).'">'. $name. '</a><i class="fa fa-circle"></i>';
        	} else {
				$html .= '<span>'.$name.'</span>';
        	}
        }
        $html .=   '</li>';
        $html .= '</ul>';
        return $html;
	});	

	HTML::macro('htext', function($field, $value = null, $attrs = [] ) {

	    if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
	    if(! array_key_exists('placeholder', $attrs) ) $attrs['placeholder'] = 'Enter '. ucfirst($attrs['label']);
	    if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
	    if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

	    $label = $attrs['label'];
	    unset($attrs['label']);
	    $html = '';
	    $html .= '<div class="form-group">';
	    $html .= 	Form::label($field, $label, ['class' => 'col-md-3 control-label'] );
	    $html .= 	'<div class="col-md-7">';
		$html .= 		Form::text($field, $value, $attrs);
		$html .= 	'</div>';
		$html .= '</div>';
		return $html;

	});

	HTML::macro('hinteger', function($field, $value = null, $attrs = [] ) {
	    
	    if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
	    if(! array_key_exists('placeholder', $attrs) ) $attrs['placeholder'] = 'Enter '. ucfirst($attrs['label']);
	    if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
	    if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

	    $label = $attrs['label'];
	    unset($attrs['label']);
	    $html = '';
	    $html .= '<div class="form-group">';
	    $html .= 	Form::label($field, $label, ['class' => 'col-md-3 control-label'] );
	    $html .= 	'<div class="col-md-7">';
		$html .= 		Form::number($field, $value, $attrs);
		$html .= 	'</div>';
		$html .= '</div>';
		return $html;

	});

	HTML::macro('hpassword', function($field, $attrs = [] ) {
	    
	    if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
	    if(! array_key_exists('placeholder', $attrs) ) $attrs['placeholder'] = 'Enter '. ucfirst($field);
	    if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
	    if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

	    $label = $attrs['label'];
	    unset($attrs['label']);

	    $html = '';
	    $html .= '<div class="form-group">';
		$html .= Form::label($field, $label, ['class' => 'col-md-3 control-label'] );
		$html .= '<div class="col-md-7">';
		$html .= Form::password( $field, $attrs );
		$html .= '</div>';
		$html .= '</div>';

        return $html;

	});

	HTML::macro('hemail', function($field, $value = null, $attrs = [] ) {
	    
	    if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
	    if(! array_key_exists('placeholder', $attrs) ) $attrs['placeholder'] = 'Enter '. ucfirst($attrs['label']);
	    if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
	    if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

	    $label = $attrs['label'];
	    unset($attrs['label']);

	    $html = '';
	    $html .= '<div class="form-group">';
	    $html .= 	Form::label($field, $label, ['class' => 'col-md-3 control-label'] );
	    $html .= 	'<div class="col-md-7">';
		$html .= 		Form::email($field, $value, $attrs);
		$html .= 	'</div>';
		$html .= '</div>';
		return $html;

	});

	HTML::macro('htextarea', function($field, $value = null, $attrs = [] ) {
	    
	    if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
	    if(! array_key_exists('placeholder', $attrs) ) $attrs['placeholder'] = 'Enter '. $attrs['label'];
	    if(! array_key_exists('rows', $attrs) ) $attrs['rows'] = 3;
	    if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
	    if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

	    $label = $attrs['label'];
	    unset($attrs['label']);

	    $html = '';
	    $html .= '<div class="form-group">';
	    $html .= 	Form::label($field, $label, ['class' => 'col-md-3 control-label'] );
	    $html .= 	'<div class="col-md-7">';
		$html .= 		Form::textarea($field, $value, $attrs);
		$html .= 	'</div>';
		$html .= '</div>';
		return $html;

	});

	HTML::macro('hselect', function($field, $values = [], $value = null, $attrs = [] ) {

		if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
	    if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
	    if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

	    $label = $attrs['label'];
	    unset($attrs['label']);

	    $html = '';
	    $html .= '<div class="form-group">';
	    $html .= 	Form::label($field, $label, ['class' => 'col-md-3 control-label'] );
	    $html .= 	'<div class="col-md-7">';
		$html .= 		Form::select($field, $values, $value, $attrs );
		$html .= 	'</div>';
		$html .= '</div>';
		return $html;

    });

    HTML::macro('hfile', function($field, $attrs = [] ) {
	    
	    if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
	    if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
	    if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

	    $label = $attrs['label'];
	    unset($attrs['label']);

	    $html = '';
	    $html .= '<div class="form-group">';
	    $html .= 	Form::label($field, $label, ['class' => 'col-md-3 control-label'] );
	    $html .= 	'<div class="col-md-7">';
		$html .= 		Form::file($field, $attrs);
        if( isset($attrs['notes']) ) $html .= '<span class="help-block">'. $attrs['notes'] .'</span>';
		$html .= 	'</div>';
		$html .= '</div>';
		return $html;

	});

    HTML::macro('himage', function($field, $attrs = [] ) {

        if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
        if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
        if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

        $label = $attrs['label'];
        unset($attrs['label']);

        $html = '';
	    $html .= '<div class="form-group">';
	    $html .= 	Form::label($field, $label, ['class' => 'col-md-3 control-label'] );
	    $html .= 	'<div class="col-md-5">';
		$html .= 		Form::file($field, $attrs);
		$html .= 	'</div>';
		$html .= 	'<div class="col-md-2">';

		if( isset($attrs['value']) ) {
			$value =  $attrs['value'];
			$html .= 	HTML::image( $value, $label, ['style' => 'width:100%; height%', 'class' => 'thumb-sm light-image']);
		} else {
			$html .= 	HTML::image( 'uploads/not-found.png', 'not-found', ['style' => 'width:100%; height%']);
		}			

		$html .= 	'</div>';
		$html .= '</div>';
		return $html;

    });

    HTML::macro('hvideo', function($field, $attrs = [] ) {

        if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
        if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
        if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

        $label = $attrs['label'];
        unset($attrs['label']);

        $html = '';
	    $html .= '<div class="form-group">';
	    $html .= 	Form::label($field, $label, ['class' => 'col-md-3 control-label'] );
	    $html .= 	'<div class="col-md-5">';
		$html .= 		Form::file($field, $attrs);
		$html .= 	'</div>';
		$html .= 	'<div class="col-md-2">';

		if( isset($attrs['value']) ) {
			$value = $attrs['value'];
			$html .= '<video width="400" controls><source src="'.$value.'" type="video/mp4"> Your browser does not support HTML5 video. </video>';
		} else {
			$html .= 	HTML::image( 'uploads/video.png', 'not-found', ['style' => 'width:100%; height%']);
		}			

		$html .= 	'</div>';
		$html .= '</div>';
		return $html;

    });

    ////////////// vertical forms //////////////////////
    HTML::macro('vtext', function($field, $value = null, $attrs = [] ) {

        if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
        if(! array_key_exists('placeholder', $attrs) ) $attrs['placeholder'] = 'Enter '. ucfirst($attrs['label']);
        if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
        if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

        $label = $attrs['label'];
        unset($attrs['label']);
        $html = '';
        $html .= '<div class="form-group">';
        $html .= 	Form::label($field, $label, ['class' => 'form-control-label'] );
        $html .= 		Form::text($field, $value, $attrs);
        $html .= '</div>';
        return $html;

    });

    HTML::macro('vinteger', function($field, $value = null, $attrs = [] ) {

        if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
        if(! array_key_exists('placeholder', $attrs) ) $attrs['placeholder'] = 'Enter '. ucfirst($attrs['label']);
        if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
        if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

        $label = $attrs['label'];
        unset($attrs['label']);
        $html = '';
        $html .= '<div class="form-group">';
        $html .= 	Form::label($field, $label, ['class' => 'form-control-label'] );
        $html .= 		Form::number($field, $value, $attrs);
        $html .= '</div>';
        return $html;

    });

    HTML::macro('vpassword', function($field, $attrs = [] ) {

        if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
        if(! array_key_exists('placeholder', $attrs) ) $attrs['placeholder'] = 'Enter '. ucfirst($field);
        if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
        if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

        $label = $attrs['label'];
        unset($attrs['label']);

        $html = '';
        $html .= '<div class="form-group">';
        $html .= Form::label($field, $label, ['class' => 'form-control-label'] );
        $html .= Form::password( $field, $attrs );
        $html .= '</div>';

        return $html;

    });

    HTML::macro('vemail', function($field, $value = null, $attrs = [] ) {

        if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
        if(! array_key_exists('placeholder', $attrs) ) $attrs['placeholder'] = 'Enter '. ucfirst($attrs['label']);
        if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
        if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

        $label = $attrs['label'];
        unset($attrs['label']);

        $html = '';
        $html .= '<div class="form-group">';
        $html .= 	Form::label($field, $label, ['class' => 'form-control-label'] );
        $html .= 		Form::email($field, $value, $attrs);
        $html .= '</div>';
        return $html;

    });

    HTML::macro('vtextarea', function($field, $value = null, $attrs = [] ) {

        if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
        if(! array_key_exists('placeholder', $attrs) ) $attrs['placeholder'] = 'Enter '. $attrs['label'];
        if(! array_key_exists('rows', $attrs) ) $attrs['rows'] = 3;
        if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
        if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

        $label = $attrs['label'];
        unset($attrs['label']);

        $html = '';
        $html .= '<div class="form-group">';
        $html .= 	Form::label($field, $label, ['class' => 'form-control-label'] );
        $html .= 		Form::textarea($field, $value, $attrs);
        $html .= '</div>';
        return $html;

    });

    HTML::macro('vselect', function($field, $values = [], $value = null, $attrs = [] ) {

        if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
        if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
        if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

        $label = $attrs['label'];
        unset($attrs['label']);

        $html = '';
        $html .= '<div class="form-group">';
        $html .= 	Form::label($field, $label, ['class' => 'form-control-label'] );
        $html .= 		Form::select($field, $values, $value, $attrs );
        $html .= '</div>';
        return $html;

    });

    HTML::macro('vfile', function($field, $attrs = [] ) {

        if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
        if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
        if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

        $label = $attrs['label'];
        unset($attrs['label']);

        $html = '';
        $html .= '<div class="form-group">';
        $html .= 	Form::label($field, $label, ['class' => 'form-control-label'] );
        $html .= 		Form::file($field, $attrs);
        if( isset($attrs['notes']) ) $html .= '<span class="help-block">'. $attrs['notes'] .'</span>';
        $html .= '</div>';
        return $html;

    });

    HTML::macro('vimage', function($field, $attrs = [] ) {

        if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
        if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
        if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

        $label = $attrs['label'];
        unset($attrs['label']);

        $html = '';
        $html .= '<div class="form-group">';
        $html .= 	Form::label($field, $label, ['class' => 'form-control-label'] );
        $html .= 	'<div class="row"> <div class="col-md-9">';
        $html .= 		Form::file($field, $attrs);
        $html .= 	'</div>';
        $html .= 	'<div class="col-md-3">';

        if( isset($attrs['value']) ) {
            $value =  $attrs['value'];

            $html .= '<a href="'. getImageUrl($value) .'" class="light-image">';
                $html .= 	HTML::image( $value, $label, ['style' => 'width: 40px; height:40px', 'class' => 'thumb-sm']);
            $html .= '</a>';

        } else {
            $html .= 	HTML::image( 'uploads/not-found.png', 'not-found', ['style' => 'width:50%; height%']);
        }

        $html .= 	'</div></div>';
        $html .= '</div>';
        return $html;

    });

    HTML::macro('vvideo', function($field, $attrs = [] ) {

        if(! array_key_exists('label', $attrs) ) $attrs['label'] = ucfirst($field);
        if(! array_key_exists('id', $attrs) ) $attrs['id'] = $field;
        if(! array_key_exists('class', $attrs) ) $attrs['class'] = 'form-control';

        $label = $attrs['label'];
        unset($attrs['label']);

        $html = '';
        $html .= '<div class="form-group">';
        $html .= 	Form::label($field, $label, ['class' => 'col-md-3 control-label'] );
        $html .= 	'<div class="col-md-5">';
        $html .= 		Form::file($field, $attrs);
        $html .= 	'</div>';
        $html .= 	'<div class="col-md-2">';

        if( isset($attrs['value']) ) {
            $value = $attrs['value'];
            $html .= '<video width="400" controls><source src="'.$value.'" type="video/mp4"> Your browser does not support HTML5 video. </video>';
        } else {
            $html .= 	HTML::image( 'uploads/video.png', 'not-found', ['style' => 'width:100%; height%']);
        }

        $html .= 	'</div>';
        $html .= '</div>';
        return $html;

    });