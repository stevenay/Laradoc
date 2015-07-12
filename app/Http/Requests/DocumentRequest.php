<?php namespace App\Http\Requests;

use App\Document;
use App\Http\Requests\Request;

class DocumentRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$document = $this->route('documents');

		$rules = [ 'content' => 'required|min:3' ];

		switch($this->method()) {
			case 'POST':
				$rules[] = [ 'title' => 'unique:documents,title,NULL,id,category_id,'.$this->input('category_id').'|required|min:3' ];
				break;
			case 'PUT':
			case 'PATCH':
				$rules['title'] = "unique:documents,title,$document->id,id,category_id,{$this->input('category_id')}|required|min:3";
				break;
			default:break;
		}

		return $rules;
	}

}
