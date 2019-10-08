<?php 
	function lang ($phrase){

		static $lang = array(

			'HOME_ADMIN' => 'Admin Panel',
			'CATAGORIES' => 'Catagories',
			'ITEMS'      => 'Items',
			'MEMBERS'	 => 'Members',
			'COMMENTS'    =>  'Comments',
			'STATISTICS' =>  'Statistics' 
		);

	return $lang[$phrase];

}

?>