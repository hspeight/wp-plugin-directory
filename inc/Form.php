<?php

// WP_List_Table is not loaded automatically so we need to load it in our application
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class Example_List_Table extends WP_List_Table
{
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ) );
        $perPage = 14;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);
        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );
        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }
    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            'id'          => 'Plugin',
            'description' => 'Description',
            'lastupdate'  => 'Last Update',
            'installs'    => 'Active Installs',
            'testedto'    => 'Tested To'
        );
        return $columns;
    }
    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }
    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array('id' => array('id', false));
    }
    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data()
    {
        $data = array();
        $data[] = array(
                    'id'          => 'Some random plugin',
                    'description' => 'Lorm ipsum',
                    'lastupdate'  => 'A while back',
                    'installs'    => 'Enough',
                    'testedto'    => '1.2.3'
                    );
        $data[] = array(
                    'id'          => 'Another random plugin',
                    'description' => 'Aliquam erat volutpat',
                    'lastupdate'  => 'Ages ago',
                    'installs'    => 'A sackfull',
                    'testedto'    => '4.5.6'
                    );
        $data[] = array(
                    'id'          => 'Not another one',
                    'description' => 'Maecenas vel dolor ipsum',
                    'lastupdate'  => 'Recently',
                    'installs'    => 'Shedloads',
                    'testedto'    => '7.8.9'
                    );
        return $data;
    }
    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'id':
            case 'description':
            case 'lastupdate':
            case 'installs':
            case 'testedto':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }
    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b )
    {
        // Set defaults
        $orderby = 'id';
        $order = 'asc';
        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }
        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }
        $result = strcmp( $a[$orderby], $b[$orderby] );
        if($order === 'asc')
        {
            return $result;
        }
        return -$result;
    }
}
?>
