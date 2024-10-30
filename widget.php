<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Creating the widget
class congoroWidgetWordpressWidget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
        // Base ID of your widget
            'congoro_widget_wordpress_widget',

            // Widget name will appear in UI
            __('ویجت کانگورو', 'congoro_widget_domain'),

            // Widget description
            array('description' => __('هر جایی که این ابزارک را قرار دهید ویجت کانگورو همان جا نمایش داده خواهد شد.', 'congoro_widget_domain'),)
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance)
    {
        if (is_single()) {
            $active_widgets = (array)json_decode(get_option('congoro_widgets_settings'));

            if (isset($active_widgets[$instance['widgetId']])) {
                $widget = (array)$active_widgets[$instance['widgetId']];
                if ($widget['displayType'] === 'widget') {
                    $title = apply_filters('widget_title', $instance['title']);
                    // before and after widget arguments are defined by themes
                    echo $args['before_widget'];
                    if (!empty($title))
                        echo $args['before_title'] . $title . $args['after_title'];

                    // This is where you run the code and display the output
                    echo congoroWidgetFunctions::stripBackslashes($widget['widgetCode']);
                    echo $args['after_widget'];
                }
            }
        }
    }

    // Widget Backend
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('مطالب مرتبط', 'congoro_widget_domain');
        }

        $widgetId = $instance['widgetId'];


        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('widgetId'); ?>">انتخاب ویجت:</label>
            <select class="widefat" id="<?php echo $this->get_field_id('widgetId'); ?>"
                    name="<?php echo $this->get_field_name('widgetId'); ?>">
                <?php
                $active_widgets = (array)json_decode(get_option('congoro_widgets_settings'));

                $n = 1;
                foreach ($active_widgets as $widget) {
                    $widget = (array)$widget;
                    ?>
                    <option
                        <?php echo($widget['displayType'] != 'widget' ? 'disabled' : '') ?>
                        <?php echo($widgetId === $widget['widgetId'] ? 'selected' : '') ?>
                        value="<?php echo $widget['widgetId'] ?>">ویجت <?= $n++; ?></option>
                    <?php
                }
                ?>

            </select>
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['widgetId'] = (!empty($new_instance['widgetId'])) ? strip_tags($new_instance['widgetId']) : '';

        return $instance;
    }
} // Class wpb_widget ends here



