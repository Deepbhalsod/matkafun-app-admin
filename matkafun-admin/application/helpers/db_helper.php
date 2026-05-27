<?php
// -----------------------------------------------------------
// 					GET_DATA_FROM FUNCTION
// -----------------------------------------------------------
if (!function_exists('get_data_from')) {
	/** Format Numaric String to Indian Currency Format
	 * @param mixed $price
	 * @return string|0 */
	function get_data_from($table)
	{
		$ci = get_instance();
		if ($ci->db->table_exists($table)) {
			$ci->tableName = $table;

			$ci->db->select($table . '.*, parent.first_name, parent.last_name, parent.profile_pic');

			$ci->db->field_exists('created_by', $ci->tableName)
				and $ci->db->join('users as parent', $table . '.created_by = parent.id');

			$ci->db->where([$table . '.status' => true]);
			$ci->db->order_by($table . '.id', 'desc');

			$query = $ci->db->get($ci->tableName);
			return $query->result();
		}
		return error_show('`' . $table . '` Table Not Exists.');
	}
}



// -----------------------------------------------------------
// 					GET_SINGLE_DATA_FROM FUNCTION
// -----------------------------------------------------------
if (!function_exists('get_signle_data_from')) {

	/** Get Single Object Row from Table
	 * @param string $table Table Name
	 * @param array $condition Where Condition
	 * @return object|error_string */
	function get_signle_data_from(string $table = '', array $condition = [])
	{
		/** @var object Codeigniter Instance */
		$ci = get_instance();
		if ($ci->db->table_exists($table)) {
			$ci->tableName = $table;

			$ci->db->select('*');

			!empty($condition) and $ci->db->where($condition);

			$query = $ci->db->get($ci->tableName);


			if (is_array($query->result()) && !empty($query->result()))
				return $query->result()[0];
			return FALSE;
		}
		return error_show('`' . $table . '` Table Not Exists.');
	}
}



// -----------------------------------------------------------
// 					GET_UNIQUE_SLUG FUNCTION
// -----------------------------------------------------------
if (!function_exists('get_unique_slug')) {

	/** Get Unique Slug From Title
	 * @param string $table Table Name where to check
	 * @param string $title Title which is use for create slug
	 * @return string Slug */
	function get_unique_slug(string $table = '', string $title = ''): string
	{
		$slug = url_title($title, '-');
		$slug_exits = get_signle_data_from($table, ['slug' => $slug]);

		if (isset($slug_exits) && !empty($slug_exits) && is_object($slug_exits)) {
			$check = 0;
			while ($check != 1) {
				$slug = increment_string(url_title($slug), '-');
				$slugCheck = get_signle_data_from($table, ['slug' => $slug]);
				if (!(isset($slugCheck) && !empty($slugCheck) && is_object($slugCheck))) {
					return $slug;
				}
			}
		}
		return $slug;
	}
}

function count_something($table, $condition)
{
	$ci = &get_instance();

	$ci->db->where($condition);

	$ci->db->from($table);
	$return = $ci->db->count_all_results();

	return $return;
}

function product_in_category($category_id)
{
	$ci = &get_instance();

	$ci->db->where(['category_id' => $category_id]);

	$ci->db->from('products');
	$return = $ci->db->count_all_results();

	return $return;
}
/* End of file db_helper.php */
