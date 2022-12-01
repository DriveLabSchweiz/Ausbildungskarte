<?php
/*
Plugin Name: DriveLab Assessment
Plugin URI: https://drivelab.ch
Description: DriveLab Assessment
Author: DriveLab
Author URI: https://drivelab.ch
Text Domain: drivelab-assessment
Domain Path: /languages/
Version: 1.0
*/
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('wcAssessment', plugins_url('/script.js', __FILE__), array('jquery')); // get_template_directory_uri()

});

add_action( 'woocommerce_order_item_meta_start', function( $item_id, $item, $product ) {

    $appointment_ids = WC_Appointment_Data_Store::get_appointment_ids_from_order_and_item_id( $item->get_order_id(), $item_id );
    if ( $appointment_ids ) {
        foreach ($appointment_ids as $appointment_id) {
            $appointment = get_wc_appointment( $appointment_id );
            if (get_field('assessment_show', $appointment->get_id())) {
                ?>
                <div class="wc-appointment-summary" style="margin-top: 10px; margin-bottom: 10px;">
                    <div class="wc-appointment-summary-name">
                        <h4 style="margin-bottom: 5px; margin-top:15px;">Bewertung</h4>
                        <p><?php echo get_field('assessment_notice', $appointment->get_id()); ?></p>
						<p><?php echo get_field('assessment_places', $appointment->get_id()); ?></p>

                        <?php
                            $assessmentGroups = [
                                'Vorschulung' => [
                                    'assessment_1_1' => 'Sitz und Spiegel einstellen',
                                    'assessment_1_2' => 'Fahrzeug Bedienung (z.B. blinken)',
                                    'assessment_1_3' => 'Lenken',
                                    'assessment_1_4' => 'Blicktechnik',
                                    'assessment_1_5' => 'Sicherung des Fahrzeuges',
                                ],
                                'Grundschulung' => [
                                    'assessment_2_1' => 'Fahrbahnbenützung',
                                    'assessment_2_2' => 'Abbiegen',
                                    'assessment_2_3' => 'Fahrstreifen, Spurwechsel',
                                    'assessment_2_4' => 'Beobachtung, Spiegelbenützung',
                                    'assessment_2_5' => 'Bremsbereitschaft, Sichtpunkte',
                                    'assessment_2_6' => 'Steigung und Gefälle',
                                    'assessment_2_7' => 'Kein Vortritt, Stop',
                                    'assessment_2_8' => 'Verzweigungen',
                                    'assessment_2_9' => 'Lichtsignale',
                                ],
                                'Manöver' => [
                                    'assessment_3_1' => 'Vorwärts Parkieren',
                                    'assessment_3_2' => 'Rückwärts Parkieren',
                                    'assessment_3_3' => 'Seitwärts Parkieren',
                                    'assessment_3_4' => 'Wenden',
                                    'assessment_3_5' => 'Rückwärts Fahren',
                                    'assessment_3_6' => 'Notbremsung',
                                    'assessment_3_7' => 'Bergsichern'
                                ],
                                'Hauptschulung' => [
                                    'assessment_4_1' => 'Geschwindigkeit',
                                    'assessment_4_2' => 'Gefahren',
                                    'assessment_4_3' => 'Engpässe, schwieriges kreuzen',
                                    'assessment_4_4' => 'Vortritt nutzen und gewähren',
                                    'assessment_4_5' => 'Einspuren',
                                    'assessment_4_6' => 'Verhalten gegenüber öffentlichen Verkehrsmitteln',
                                    'assessment_4_7' => 'Überholen',
                                    'assessment_4_8' => 'Signale und Markierungen',
                                    'assessment_4_9' => 'Abstand vorne und seitlich',
                                    'assessment_4_10' => 'Kreisverkehrsplätze',
                                    'assessment_4_11' => 'Lückenbenutzung',
                                    'assessment_4_12' => 'Grössere Verzweigungen',
                                ],

                                'Perfektionsschulung' => [
                                    'assessment_5_1' => 'Autobahn',
                                    'assessment_5_2' => 'Wegweiserfahrt',
                                    'assessment_5_3' => 'Vorprüfung',
                                ]
                            ]
                        ?>

                        <?php foreach ($assessmentGroups as $assessmentGroupTitle => $assessmentGroup) { ?>
                            <h4 style="margin-bottom: 5px; margin-top:15px;"><?= $assessmentGroupTitle ?></h4>
                            <?php foreach ($assessmentGroup as $assessmentKey => $assessmentText) {
                                $percentage = get_field($assessmentKey, $appointment->get_id()) ?: 0;
                                ?>
                                <div style="border:1px solid #6EC1E4; margin-bottom: 5px; border-radius:5px; line-height: 25px; font-size: 13px; text-indent: 40px; position: relative;">
                                    <div style="position: relative; z-index: 2"><?= $assessmentText ?></div>
                                    <div style="position: absolute; top: 0; left: 0; text-indent: 5px; height: 100%; background:rgba(110, 193, 228, 0.2); width:<?= $percentage ?>%"><?= $percentage ?>%</div>
                                </div>
                        <?php } } ?>
                    </div>
                </div>
                <?php
            }
        }
    }

}, 11, 3 );
