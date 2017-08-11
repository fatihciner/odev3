<?php
namespace App\Http\Controllers\EFT;

use Validator;

class ApiField
{

	private $type;
	private $name;
	private $value;

	private function __construct($type='', $name='', $value='')
	{
		$this->type = $type;
		$this->name = $name;
		$this->value = $value;
	}

	public static function email($data = '')
	{

//		$validator = Validator::make();
//		$validator->after(function ($validator)  use ($email){
//			if ($email!='24234')
//			{
//				$validator->errors()->add('field', 'Giriş Bilgileri Geçersizzzzz!');
//			}
//		})->validate();

		self::validateFieldData(
				[ FieldType::EMAIL => $data ],
				[ FieldType::EMAIL => 'required|between:5,55' ]
		);
		return new ApiField(FieldType::EMAIL, 'email', $data, 'E-MAIL', '');

	}

	public static function password($data = '')
	{
		self::validateFieldData(
			[ FieldType::PASSWORD => $data ],
			[ FieldType::PASSWORD => 'required|between:1,40' ]
		);

		return new ApiField(FieldType::PASSWORD, 'password', $data, 'PASSWORD', 'Must be between 3-50 chars');
	}

	public static function test($data = '')
	{


		return new ApiField(FieldType::TOKEN, 'tokentest', $data, 'tokentest', '');
	}


	private static function validateFieldData($input=[], $rules=[])
	{
		$validator = Validator::make($input, $rules);
		$validator->validate();


//		if ($validator->fails())
//		{
//			//Redirect::back()->withErrors(['msg', 'The Message']);
//			return  Redirect::back()->withInput()->withErrors($validator->errors());
//		}
	}


	public function getType()
	{
		return $this->type;
	}

	public function getValue()
	{
		return $this->value;
	}
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

}