<?php if (!class_exists('DealerInspire_Vessel')) {
  die();
}
//Block Direct Access
?>
<select <?php echo array_key_exists('class', $setting)
  ? 'class="' . $setting['class'] . '"'
  : ''; ?> name="<?php echo $prefix . $id; ?>" id="<?php echo $prefix . $id; ?>">
    <option value="">STATE</option>
    <optgroup label="USA">
        <option value="AL" <?php selected(get_option($prefix . $id), 'AL'); ?>>AL</option>
        <option value="AK" <?php selected(get_option($prefix . $id), 'AK'); ?>>AK</option>
        <option value="AZ" <?php selected(get_option($prefix . $id), 'AZ'); ?>>AZ</option>
        <option value="AR" <?php selected(get_option($prefix . $id), 'AR'); ?>>AR</option>
        <option value="CA" <?php selected(get_option($prefix . $id), 'CA'); ?>>CA</option>
        <option value="CO" <?php selected(get_option($prefix . $id), 'CO'); ?>>CO</option>
        <option value="CT" <?php selected(get_option($prefix . $id), 'CT'); ?>>CT</option>
        <option value="DE" <?php selected(get_option($prefix . $id), 'DE'); ?>>DE</option>
        <option value="DC" <?php selected(get_option($prefix . $id), 'DC'); ?>>DC</option>
        <option value="FL" <?php selected(get_option($prefix . $id), 'FL'); ?>>FL</option>
        <option value="GA" <?php selected(get_option($prefix . $id), 'GA'); ?>>GA</option>
        <option value="HI" <?php selected(get_option($prefix . $id), 'HI'); ?>>HI</option>
        <option value="ID" <?php selected(get_option($prefix . $id), 'ID'); ?>>ID</option>
        <option value="IL" <?php selected(get_option($prefix . $id), 'IL'); ?>>IL</option>
        <option value="IN" <?php selected(get_option($prefix . $id), 'IN'); ?>>IN</option>
        <option value="IA" <?php selected(get_option($prefix . $id), 'IA'); ?>>IA</option>
        <option value="KS" <?php selected(get_option($prefix . $id), 'KS'); ?>>KS</option>
        <option value="KY" <?php selected(get_option($prefix . $id), 'KY'); ?>>KY</option>
        <option value="LA" <?php selected(get_option($prefix . $id), 'LA'); ?>>LA</option>
        <option value="ME" <?php selected(get_option($prefix . $id), 'ME'); ?>>ME</option>
        <option value="MD" <?php selected(get_option($prefix . $id), 'MD'); ?>>MD</option>
        <option value="MA" <?php selected(get_option($prefix . $id), 'MA'); ?>>MA</option>
        <option value="MI" <?php selected(get_option($prefix . $id), 'MI'); ?>>MI</option>
        <option value="MN" <?php selected(get_option($prefix . $id), 'MN'); ?>>MN</option>
        <option value="MS" <?php selected(get_option($prefix . $id), 'MS'); ?>>MS</option>
        <option value="MO" <?php selected(get_option($prefix . $id), 'MO'); ?>>MO</option>
        <option value="MT" <?php selected(get_option($prefix . $id), 'MT'); ?>>MT</option>
        <option value="NE" <?php selected(get_option($prefix . $id), 'NE'); ?>>NE</option>
        <option value="NV" <?php selected(get_option($prefix . $id), 'NV'); ?>>NV</option>
        <option value="NH" <?php selected(get_option($prefix . $id), 'NH'); ?>>NH</option>
        <option value="NJ" <?php selected(get_option($prefix . $id), 'NJ'); ?>>NJ</option>
        <option value="NM" <?php selected(get_option($prefix . $id), 'NM'); ?>>NM</option>
        <option value="NY" <?php selected(get_option($prefix . $id), 'NY'); ?>>NY</option>
        <option value="NC" <?php selected(get_option($prefix . $id), 'NC'); ?>>NC</option>
        <option value="ND" <?php selected(get_option($prefix . $id), 'ND'); ?>>ND</option>
        <option value="OH" <?php selected(get_option($prefix . $id), 'OH'); ?>>OH</option>
        <option value="OK" <?php selected(get_option($prefix . $id), 'OK'); ?>>OK</option>
        <option value="OR" <?php selected(get_option($prefix . $id), 'OR'); ?>>OR</option>
        <option value="PA" <?php selected(get_option($prefix . $id), 'PA'); ?>>PA</option>
        <option value="RI" <?php selected(get_option($prefix . $id), 'RI'); ?>>RI</option>
        <option value="SC" <?php selected(get_option($prefix . $id), 'SC'); ?>>SC</option>
        <option value="SD" <?php selected(get_option($prefix . $id), 'SD'); ?>>SD</option>
        <option value="TN" <?php selected(get_option($prefix . $id), 'TN'); ?>>TN</option>
        <option value="TX" <?php selected(get_option($prefix . $id), 'TX'); ?>>TX</option>
        <option value="UT" <?php selected(get_option($prefix . $id), 'UT'); ?>>UT</option>
        <option value="VT" <?php selected(get_option($prefix . $id), 'VT'); ?>>VT</option>
        <option value="VA" <?php selected(get_option($prefix . $id), 'VA'); ?>>VA</option>
        <option value="WA" <?php selected(get_option($prefix . $id), 'WA'); ?>>WA</option>
        <option value="WV" <?php selected(get_option($prefix . $id), 'WV'); ?>>WV</option>
        <option value="WI" <?php selected(get_option($prefix . $id), 'WI'); ?>>WI</option>
        <option value="WY" <?php selected(get_option($prefix . $id), 'WY'); ?>>WY</option>
    </optgroup>
    <optgroup label="CANADA">
        <option value="AB" <?php selected(get_option($prefix . $id), 'AB'); ?>>AB</option>
        <option value="BC" <?php selected(get_option($prefix . $id), 'BC'); ?>>BC</option>
        <option value="MB" <?php selected(get_option($prefix . $id), 'MB'); ?>>MB</option>
        <option value="NB" <?php selected(get_option($prefix . $id), 'NB'); ?>>NB</option>
        <option value="NL" <?php selected(get_option($prefix . $id), 'NL'); ?>>NL</option>
        <option value="NS" <?php selected(get_option($prefix . $id), 'NS'); ?>>NS</option>
        <option value="ON" <?php selected(get_option($prefix . $id), 'ON'); ?>>ON</option>
        <option value="PE" <?php selected(get_option($prefix . $id), 'PE'); ?>>PE</option>
        <option value="QC" <?php selected(get_option($prefix . $id), 'QC'); ?>>QC</option>
        <option value="SK" <?php selected(get_option($prefix . $id), 'SK'); ?>>SK</option>
        <option value="NT" <?php selected(get_option($prefix . $id), 'NT'); ?>>NT</option>
        <option value="NU" <?php selected(get_option($prefix . $id), 'NU'); ?>>NU</option>
        <option value="YT" <?php selected(get_option($prefix . $id), 'YT'); ?>>YT</option>
    </optgroup>
</select>