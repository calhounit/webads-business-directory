<?php
/**
 * This file contains code snippets for adding category support to the business update template.
 * These snippets should be integrated into the webads-business-update-template.php file.
 */

/**
 * SNIPPET 1: Add to the form processing section where other fields are processed
 * Add this after the line that gets the title: $title = $_POST['field_title'];
 */
$category = isset($_POST['field_category']) ? $_POST['field_category'] : '';

/**
 * SNIPPET 2: Add to the post-processing section after all the add_post_meta calls
 * Add this after the line: add_post_meta($post_id, 'business_details', $details);
 */
// Set the business category
if (!empty($category)) {
    wp_set_object_terms($post_id, intval($category), 'business_category');
} else {
    // Default to "Uncategorized" if no category is selected
    $uncategorized = get_term_by('slug', 'uncategorized', 'business_category');
    if ($uncategorized) {
        wp_set_object_terms($post_id, $uncategorized->term_id, 'business_category');
    }
}

/**
 * SNIPPET 3: Add to the section where existing business data is loaded
 * Add this after loading other metadata like $details
 */
// Get the current category
$current_terms = wp_get_object_terms($postid, 'business_category', array('fields' => 'ids'));
$current_category = !empty($current_terms) ? $current_terms[0] : '';

/**
 * SNIPPET 4: Add to the section for new business defaults
 * Add this after setting other default values
 */
// Default to "Uncategorized" for new businesses
$uncategorized = get_term_by('slug', 'uncategorized', 'business_category');
$current_category = $uncategorized ? $uncategorized->term_id : '';

/**
 * SNIPPET 5: Add the category dropdown field to the form
 * Add this after the business name field and before the address field
 */
?>
<!-- Business Category Field -->
<div id="frm_category_container"
     class="frm_form_field form-field frm_required_field frm_top_container frm_full">
    <label for="field_category" id="field_category_label"
           class="frm_primary_label">Business Category
        <span class="frm_required">*</span>
    </label>
    <select id="field_category" name="field_category" aria-required="true">
        <?php
        // Get all business categories
        $categories = get_terms(array(
            'taxonomy' => 'business_category',
            'hide_empty' => false,
        ));
        
        if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $category) {
                $selected = ($current_category == $category->term_id) ? ' selected="selected"' : '';
                echo '<option value="' . $category->term_id . '"' . $selected . '>' . $category->name . '</option>';
            }
        }
        ?>
    </select>
</div>
