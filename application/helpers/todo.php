<?php
/**
 * Todo helper class.
 *
 * @package     Toodle
 * @author      Terry Morgan <terry.morgan@marmaladeontoast.co.uk>
 * @copyright   (c) 2011 Terry Morgan
 */
class todo_Core {

  /**
   * get_due_date
   *
   * Takes a description string as entered by the user and attempts to seperate out
   * a due date if one is detected. The format of the input is "due date|description".
   *
   * @return (Array) Seperate due date and description || (String) The description
   * @author Terry Morgan
   **/
  public static function get_due_date($description=false)
  {
    $due_date = false;

    if ($description)
    {
      // Attempt to split out the due date, if there is one
      $parts = explode('|', $description);

      // if there is a due date included, save the date and description
      // and add a validation callback to validate the date. We're using
      // a custom validation routine for additional flexibility

      if( count($parts) > 1 )
      {
        $due_date = array(
          'due_date' => $parts[0],
          'description' => $parts[1],
        );
      }
      else
      {
        $due_date = $description;
      }
    }

    return $due_date;
  }

  /**
   * convert_due_date
   *
   * Validates a todos due date as entered by the user. Currently only accepts dd/mm/yy or dd/mm/yyyy
   * but I plan to implement more date formats including times, "tomorrow", "wednesday" etc.
   *
   * @return Array || Bool
   * @author Terry Morgan
   **/
  public static function convert_due_date($due_date, $time=false)
  {
    $converted_date = false;

    if ($timestamp = strtotime($due_date))
    {
      $converted_date = Date('Y-m-d H:i:s', $timestamp);
    }

    return $converted_date;
  }

  /**
   * display_due_date
   *
   * Nicely formats the due date / time for display to user
   *
   * @return String
   * @author Terry Morgan
   **/
  public function display_due_date($due_date=false)
  {
    $display_date = false;

    if ($due_date)
    {
      $date_parts = explode(' ', $due_date);

      if ($date_parts[1] === '00:00:00')
      {
        $format = 'd/m/y';
      }
      else
      {
        $format = 'd/m/y H:i';
      }

      $display_date = Date($format, strtotime($due_date));
    }

    return $display_date;
  }

}
?>