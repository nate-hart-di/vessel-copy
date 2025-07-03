<?php /*
	Home page of the site
*/ ?>

<?php if(get_field('override_videobanner')) { ?>
<div id="override_videobanner" data-acf="override_videobanner" data-acf-location="Homepage">
  <?php the_field('override_videobanner_content'); ?>
</div>
<?php } else { ?>
<div id="videobanner" class="modfull-home">
  <?php get_template_part('partials/sliders/video_fullheight'); ?>

  <div class="gridwrap hidden-sm hidden-xs"> </div>

	  <div id="videooverlay">
		<?= get_field('overlay_text')?>
		<!--<h2> Select A Brand to Find A Dealership </h2> -->

	    <div class="videooverlay-contentwrapper hidden-xs">
		    <div class="videooverlay-content">

				<!--Logo Container -->
				<div id="intro-overlay" class="tool-overlay open">
					<div class="row">
						<div class="col-sm-12">
							<div class="brand-section">
								<div id="logos">
									<a trid="4a3cb7fdd1384ffc9de3bf" trc target="MBLocations" class="dealer-logo overlay-toggle">
										<div class="wrapper">
											<img class="manufacturer-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/mb-new.png" alt="Mercedes Benz OEM logo" />
										</div>
									</a>
                                    <a trid="a6ef053fe9b0466fad93ee" trc target="porscheLocations" class="dealer-logo overlay-toggle">
										<div class="wrapper">
											<img class="manufacturer-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/porsche-new.png" alt="Porsche OEM logo" />
										</div>
									</a>
									<a trid="9feb794e4bfe40aa8bac08" trc href="/careers/fjmw/" class="dealer-logo">
										<div class="wrapper">
											<img class="manufacturer-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/FJ Letters (square).png" alt="FJ logo" />
										</div>
									</a>
                                    <a trid="1aaceaa9f74548b0b039ce" trc target="audiLocations" class="dealer-logo overlay-toggle">
										<div class="wrapper">
											<img class="manufacturer-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/audi-emblem.png" alt="Audi OEM logo" />
										</div>
									</a>
                                    <a trid="197a787e111b42619342b4" trc target="sprinterLocations" class="dealer-logo overlay-toggle">
										<div class="wrapper">
											<img class="manufacturer-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/sprinter-new.png" alt="Sprinter OEM logo" />
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


		    <!--Toolbar Overlay -->
		    <div class="toolbar-overlays">
				<!--MB Overlay -->
				<div id="MBLocations-overlay" class="tool-overlay targetOverlay" style="display: none;">
				    <div class="overlay-container">
						<span class="close-overlay"><i class="fa fa-times"></i></span>
						<div class="overlay-content">
							<span class="arrow-animation visible-sm"></span><span class="arrow-animation visible-sm"></span><span class="arrow-animation visible-sm"></span>
							<div class="container-fluid">
                                <div class="location-box-wrapper">
									<div class="row">
										<div class="col-md-6 col-sm-12">
											<h2>California</h2>
											<div id="location-box">
												<div class="location-name">
													<h3> Fletcher Jones Motorcars </h3>
													<span class="address">3300 Jamboree Road • Newport Beach, CA 92660 </span><br/>
												</div>
												<a trid="590ae74df3ad423ab8a61a" trc target="_blank" href="https://www.fjmercedes.com" class="button primary-button">Visit</a>
											</div>
											<div id="location-box">
												<div class="location-name">
													<h3> Mercedes-Benz of Ontario </h3>
													<span class="address">3787 East Guasti Rd • Ontario, CA 91761 </span><br/>
												</div>
												<a trid="521d0bb8123c4b23b481fc" trc target="_blank" href="https://www.mbontario.com/" class="button primary-button">Visit</a>
											</div>
											<div id="location-box">
												<div class="location-name">
													<h3> Fletcher Jones Motorcars of Fremont </h3>
													<span class="address">5760 Cushing Pkwy • Fremont, CA 94538</span><br/>
												</div>
												<a trid="502cfd3db4694a5fb64b28" trc target="_blank" href="https://www.mboffremont.com" class="button primary-button">Visit</a>
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<h2>Hawaii</h2>
											<div id="location-box">
												<div class="location-name">
													<h3> Mercedes-Benz of Maui </h3>
													<span class="address">69 Hobron Ave • Kahului, HI 96732</span><br/>
												</div>
												<a trid="36ccbaf816d441feb4786d" trc target="_blank" href="https://www.mercedesbenzofhonolulu.com" class="button primary-button">Visit</a>
											</div>
											<div id="location-box">
												<div class="location-name">
													<h3> Mercedes-Benz of Honolulu </h3>
													<span class="address">818 Kapiolani Blvd • Honolulu, HI 96813</span><br/>
												</div>
												<a trid="8faae6402a6d46508920ab" trc target="_blank" href="https://www.mercedesbenzofhonolulu.com" class="button primary-button">Visit</a>
											</div>
											<div id="location-box">
												<div class="location-name">
													<h3> Mercedes-Benz Kona Service Center </h3>
													<span class="address">74-5536 Kaiwi St. Building A • Kailua-Kona HI 96740</span><br/>
												</div>
												<a trid="45fa40f376d3409ba18059" trc target="_blank" href="https://www.mercedesbenzofhonolulu.com/mercedes-benz-kona-service-center/" class="button primary-button">Visit</a>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-sm-12">
											<h2>Nevada</h2>
											<div id="location-box">
												<div class="location-name">
													<h3> Fletcher Jones Imports </h3>
													<span class="address">7300 West Sahara Ave • Las Vegas, NV 89117</span><br/>
												</div>
												<a trid="7b77ffe8bc5f44f486e035" trc target="_blank" href="https://www.fjimports.com" class="button primary-button">Visit</a>
											</div>
											<div id="location-box">
												<div class="location-name">
													<h3> Mercedes-Benz of Henderson </h3>
													<span class="address">925 Auto Show Dr • Henderson, NV 89014</span><br/>
												</div>
												<a trid="872487dbbfac4f2298ed94" trc target="_blank" href="https://www.mbofhenderson.com" class="button primary-button">Visit</a>
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<h2>Illinois</h2>
											<div id="location-box">
												<div class="location-name">
													<h3> Mercedes-Benz of Chicago </h3>
													<span class="address">Sales: 1520 W. North Ave • Chicago, IL 60642</span><br/>
													<span class="address">Service: 949 North Elston Avenue, Suite 2 • Chicago, IL 60642</span><br/>
												</div>
												<a trid="701457f823784575879082" trc target="_blank" href="https://www.mercedesbenzchicago.com" class="button primary-button">Visit</a>
											</div>
										</div>
									</div>
                                </div>
							</div>
						</div>
				    </div>
			    </div>

				<!--Porsche Locations -->
				<div id="porscheLocations-overlay" class="tool-overlay targetOverlay" style="display: none;">
				    <div class="overlay-container">
						<span class="close-overlay"><i class="fa fa-times"></i></span>
						<div class="overlay-content">
							<span class="arrow-animation visible-sm"></span><span class="arrow-animation visible-sm"></span><span class="arrow-animation visible-sm"></span>
							<div class="container-fluid">
                                <div class="location-box-wrapper">
									<div class="row">
										<div class="col-md-6 col-sm-12">
											<h2>California</h2>
											<div id="location-box">
												<div class="location-name">
													<h3> Porsche Fremont </h3>
													<span class="address">5740 Cushing Pkwy • Fremont, CA 94538 </span><br/>
												</div>
												<a trid="f60cbf8332414c309a00ec" trc target="_blank" href="https://www.porscheoffremont.com" class="button primary-button">Visit</a>
											</div>
										</div>
									</div>
                                </div>
							</div>
						</div>
				    </div>
			    </div>

				<!--Sprinter Locations -->
				<div id="sprinterLocations-overlay" class="tool-overlay targetOverlay" style="display: none;">
				    <div class="overlay-container">
						<span class="close-overlay"><i class="fa fa-times"></i></span>
						<div class="overlay-content">
							<span class="arrow-animation visible-sm"></span><span class="arrow-animation visible-sm"></span><span class="arrow-animation visible-sm"></span>
							<div class="container-fluid">
                                <div class="location-box-wrapper">
									<div class="row">
										<div class="col-md-6 col-sm-12">
											<h2>California</h2>
											<div id="location-box">
												<div class="location-name">
													<h3> FJ Motorcars of Fremont </h3>
													<span class="address">5760 Cushing Pkwy • Fremont, CA 94538</span><br/>
												</div>
												<a trid="60a20184c24f43198b20ff" trc target="_blank" href="https://www.mboffremont.com" class="button primary-button">Visit</a>
											</div>
                                            <div id="location-box">
                                                <div class="location-name">
                                                    <h3>Fletcher Jones Van Center</h3>
                                                    <span class="address">375 Bristol Street • Costa Mesa, CA 92626</span><br/>
                                                </div>
                                                <a trid="136dd3f7d1e44ac2a705b0" trc target="_blank" href="http://www.fjvans.com/" class="button primary-button">Visit</a>
                                            </div>
										</div>
										<div class="col-md-6 col-sm-12">
											<h2>Hawaii</h2>
											<div id="location-box">
												<div class="location-name">
													<h3> Mercedes-Benz of Honolulu </h3>
													<span class="address">818 Kapiolani Blvd • Honolulu, HI 96813</span><br/>
												</div>
												<a trid="f6d39d299336497993cf04" trc target="_blank" href="https://www.mercedesbenzofhonolulu.com" class="button primary-button">Visit</a>
											</div>
											<div id="location-box">
												<div class="location-name">
													<h3> Mercedes-Benz of Maui </h3>
													<span class="address">69 Hobron Ave • Kahului, HI 96732</span><br/>
												</div>
												<a trid="d98624331c4344639ef8f9" trc target="_blank" href="https://www.mercedesbenzofhonolulu.com" class="button primary-button">Visit</a>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-sm-12">
											<h2>Nevada</h2>
											<div id="location-box">
												<div class="location-name">
													<h3> Mercedes-Benz of Henderson </h3>
													<span class="address">925 Auto Show Dr • Henderson, NV 89014</span><br/>
												</div>
												<a trid="ffba3c751aa8457bb6d544" trc target="_blank" href="https://www.mbofhenderson.com" class="button primary-button">Visit</a>
											</div>
											<div id="location-box">
												<div class="location-name">
													<h3> Fletcher Jones Imports </h3>
													<span class="address">7300 West Sahara Ave • Las Vegas, NV 89117</span><br/>
												</div>
												<a trid="375a2337d7414c698fc431" trc target="_blank" href="https://www.fjimports.com" class="button primary-button">Visit</a>
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<h2>Illinois</h2>
											<div id="location-box">
												<div class="location-name">
													<h3> Mercedes-Benz of Chicago </h3>
													<span class="address">1520 W. North Ave • Chicago, IL 60642</span><br/>
												</div>
												<a trid="fe1c5993ade940db95eb7e" trc target="_blank" href="https://www.mercedesbenzchicago.com" class="button primary-button">Visit</a>
											</div>
											<div id="location-box">
												<div class="location-name">
													<h3> Sprinter of Chicago </h3>
													<span class="address">Sales: 1520 W. North Avenue • Chicago, IL 60642 </span><br/>
													<span class="address">Service: 949 North Elston Avenue, Suite 2 Chicago, IL 60642</span>
												</div>
												<a trid="1f712f25c62a42a7baec8b" trc target="_blank" href="https://www.mercedesbenzchicago.com/commercial-vans/" class="button primary-button">Visit</a>
											</div>
										</div>
									</div>
                                </div>
							</div>
						</div>
				    </div>
			    </div>

				<!--Audi Locations -->
				<div id="audiLocations-overlay" class="tool-overlay targetOverlay" style="display: none;">
				    <div class="overlay-container">
						<span class="close-overlay"><i class="fa fa-times"></i></span>
						<div class="overlay-content">
							<span class="arrow-animation visible-sm"></span><span class="arrow-animation visible-sm"></span><span class="arrow-animation visible-sm"></span>
							<div class="container-fluid">
                                <div class="location-box-wrapper">
									<div class="row">
										<div class="col-md-6 col-sm-12">
											<h2>California</h2>
											<div id="location-box">
												<div class="location-name">
													<h3> Audi Beverly Hills </h3>
													<span class="address">Sales: 8850 Wilshire Blvd • Beverly Hills, CA 90211</span><br/>
													<span class="address">Service: 2340 S Fairfax Ave • Los Angeles, CA 90016</span><br/>
												</div>
												<a trid="3094643626c44232981cc1" trc target="_blank" href="https://www.audibeverlyhills.com/" class="button primary-button">Visit</a>
											</div>
											<div id="location-box">
												<div class="location-name">
													<h3> Audi Fletcher Jones </h3>
													<span class="address">1275 Bristol St • Costa Mesa, CA 92626</span><br/> 
												</div>
												<a trid="2bf754ac382149508c6746" trc target="_blank" href="https://www.audifletcherjones.com/" class="button primary-button">Visit</a>
											</div>
											<div id="location-box">
												<div class="location-name">
													<h3> Audi Fremont </h3>
													<span class="address">43191 Boscell Rd • Fremont, CA 94538</span><br/>
												</div>
												<a trid="314f4e3475c64455aa24c1" trc target="_blank" href="https://www.audifremont.com/" class="button primary-button">Visit</a>
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<h2>Chicago</h2>
											<div id="location-box">
												<div class="location-name">
													<h3> Fletcher Jones Audi </h3>
													<span class="address">Sales: 1523 W. North Ave • Chicago, IL 60642</span><br/>
													<span class="address">Service: 949 N. Elston Ave, Suite 1 • Chicago, IL 60642 </span>
												</div>
												<a trid="2296a86fdc774f628e98f7" trc target="_blank" href="https://www.fletcherjonesaudi.com/" class="button primary-button">Visit</a>
											</div>
										</div>
									</div>
                                </div>
							</div>
						</div>
				    </div>
			    </div>

			    <!--Hawaii Locations -->
			    <div id="hawaiilocations-overlay" class="tool-overlay targetOverlay" style="display: none;">
				    <div class="overlay-container">
						<span class="close-overlay"><i class="fa fa-times"></i></span>
						<div class="overlay-content">
							<span class="arrow-animation visible-sm"></span><span class="arrow-animation visible-sm"></span><span class="arrow-animation visible-sm"></span>
							<div class="container-fluid">
                                <div class="location-box-wrapper">
									<div id="location-box">
										<div class="location-name">
											<h3> Mercedes-Benz of Honolulu </h3>
											<span class="address">818 Kapiolani Boulevard • Honolulu, HI 96813 </span><br/>
										</div>
										<a trid="66abc623b6a849389b22b8" trc target="_blank" href="https://www.mercedesbenzofhonolulu.com" class="button primary-button">Visit</a>
									</div>
                                    <div id="location-box">
                                        <div class="location-name">
                                            <h3> Mercedes-Benz of Maui </h3>
                                            <span class="address">69 Hobron Avenue • Kahului, HI 96732 </span><br/>
                                        </div>
                                        <a trid="cd9194dd06aa422e85885d" trc target="_blank" href="https://www.mbofmaui.com" class="button primary-button">Visit</a>
									</div>
									<div id="location-box">
										<div class="location-name">
											<h3> Mercedes-Benz Kona Service Center </h3>
											<span class="address">74-5536 Kaiwi St. Building A • Kailua-Kona HI 96740</span><br/>
										</div>
										<a trid="a9ec44bd66cf48e0a2c032" trc target="_blank" href="https://www.mercedesbenzofhonolulu.com/mercedes-benz-kona-service-center/" class="button primary-button">Visit</a>
									</div>
                                </div>
							</div>
						</div>
				    </div>
			    </div>

			    <!--California Locations -->
			    <div id="californialocations-overlay" class="tool-overlay targetOverlay" style="display: none;">
				    <div class="overlay-container">
					    <h2> Select A California Location: </h2>
						<span class="close-overlay"><i class="fa fa-times"></i></span>
						<div class="overlay-content">
							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-6 col-xs-6 center">
										<a trid="23101497efbf4f0fa97a41" trc target="southcalifornia" class="overlay-toggle find-button">Southern <br> California</a>
									</div>
									<div class="col-sm-6 col-xs-6 center">
										<a trid="7c28815459744704afa2dd" trc target="northcalifornia" class="overlay-toggle find-button">Northern <br> California</a>
									</div>
								</div>
							</div>
						</div>
				    </div>
			    </div>


				 <!--Southern California -->
			    <div id="southcalifornia-overlay" class="tool-overlay targetOverlay" style="display: none;">
				    <div class="overlay-container">
						<span class="close-overlay"><i class="fa fa-times"></i></span>
						<span class="back-button"><i class="fa fa-undo"></i></span>
						<div class="overlay-content">
							<span class="arrow-animation visible-sm"></span><span class="arrow-animation visible-sm"></span><span class="arrow-animation visible-sm"></span>
							<div class="container-fluid">
                                <div class="location-box-wrapper">
									<div id="location-box">
										<div class="location-name">
											<h3> Fletcher Jones Motorcars </h3>
											<span class="address">3300 Jamboree Road • Newport Beach, CA 92660 </span><br/>
										</div>
										<a trid="e1adfc5af02b4673b5a944" trc target="_blank" href="https://www.fjmercedes.com" class="button primary-button">Visit</a>
									</div>
									<div id="location-box">
										<div class="location-name">
											<h3> Audi Beverly Hills </h3>
											<span class="address">8850 Wilshire Boulevard • Beverly Hills, CA 90211 </span><br/>
											<span class="address">Service: 2340 S Fairfax Ave • Los Angeles, CA 90016</span>
										</div>
										<a trid="1245fdee70664812a49083" trc target="_blank" href="http://www.audibeverlyhills.com/" class="button primary-button">Visit</a>
									</div>
                                    <div id="location-box">
                                        <div class="location-name">
                                            <h3> Mercedes-Benz of Ontario </h3>
                                            <span class="address">3787 East Guasti Road • Ontario, CA 91761 </span><br/>
                                        </div>
                                        <a trid="0d837670c6ef4e618d2163" trc target="_blank" href="https://www.mbontario.com" class="button primary-button">Visit</a>
                                    </div>
                                    <div id="location-box">
                                        <div class="location-name">
                                            <h3>Audi Fletcher Jones</h3>
                                            <span class="address">1275 Bristol Street • Costa Mesa, CA 92626</span><br/>
                                        </div>
                                        <a trid="43f52c624ac341bb9c5c7b" trc target="_blank" href="http://www.audifletcherjones.com/" class="button primary-button">Visit</a>
                                    </div>
                                    <div id="location-box">
                                        <div class="location-name">
                                            <h3>Fletcher Jones Van Center</h3>
                                            <span class="address">375 Bristol Street • Costa Mesa, CA 92626</span><br/>
                                        </div>
                                        <a trid="21540b4bb1bc4fd59d5f7c" trc target="_blank" href="http://www.fjvans.com/" class="button primary-button">Visit</a>
                                    </div>
                                </div>
							</div>
						</div>
				    </div>
			    </div>

				<!--Northern California -->
			    <div id="northcalifornia-overlay" class="tool-overlay targetOverlay" style="display: none;">
				    <div class="overlay-container">
						<span class="close-overlay"><i class="fa fa-times"></i></span>
						<span class="back-button"><i class="fa fa-undo"></i></span>
						<div class="overlay-content">
							<div class="container-fluid">
								<div class="location-box-wrapper">

										<div id="location-box">
											<div class="location-name">
												<h3> Fletcher Jones Motorcars of Fremont </h3>
												<span class="address">5760 Cushing Parkway • Fremont, CA 94538 </span><br/>
											</div>
											<a trid="06e44aec14f6422cb6c703" trc target="_blank" href="https://www.mboffremont.com" class="button primary-button">Visit</a>
										</div>

										<div id="location-box">
											<div class="location-name">
												<h3> Porsche Fremont </h3>
												<span class="address">5740 Cushing Parkway • Fremont, CA 94538 </span><br/>
											</div>
											<a trid="712c9d59f07d48fa935f98" trc target="_blank" href="https://www.porscheoffremont.com" class="button primary-button">Visit</a>
										</div>


										<div id="location-box">
											<div class="location-name">
												<h3> Audi Fremont</h3>
												<span class="address">43191 Boscell Road • Fremont, CA 94538</span><br />
											</div>
											<a trid="20d7fd12b4444653be42f4" trc target="_blank" href="http://www.audifremont.com/" class="button primary-button">Visit</a>
										</div>
								</div>
							</div>
						</div>
				    </div>
			    </div>

			    <!--Nevada Locations -->
			    <div id="nevadalocations-overlay" class="tool-overlay targetOverlay" style="display: none;">
				    <div class="overlay-container">
						<span class="close-overlay"><i class="fa fa-times"></i></span>
						<div class="overlay-content">
							<div class="container-fluid">
									<div class="location-box-wrapper">
										<div id="location-box">
											<div class="location-name">
												<h3> Fletcher Jones Imports </h3>
												<span class="address">7300 W Sahara Ave • Las Vegas, NV 89117 </span>
											</div>
											<a trid="f3805c27422f46aea82e41" trc target="_blank" href="https://www.fjimports.com/" class="button primary-button">Visit</a>
										</div>
										<div id="location-box">
											<div class="location-name">
												<h3>Fletcher Jones Imports Sprinter Service</h3>
												<span class="address">8075 W Sahara Ave • Las Vegas, NV 89117 </span>
											</div>
											<a trid="65e0350d80b6429d9751a1" trc target="_blank" href="https://www.fjimports.com/commercial-vans/" class="button primary-button">Visit</a>
										</div>

										<div id="location-box">
											<div class="location-name">
												<h3> Mercedes-Benz of Henderson </h3>
												<span class="address">925 Auto Show Drive • Henderson, NV 89014 </span><br />
											</div>
											<a trid="cb348e031355471994a94d" trc target="_blank" href="https://www.mbofhenderson.com/" class="button primary-button">Visit</a>
										</div>
										<div id="location-box">
											<div class="location-name">
												<h3> Fletcher Jones Imports Used Car & Truck Center </h3>
												<span class="address">7100 W Sahara Ave, Las Vegas, NV 89117</span><br />
											</div>
											<a trid="acf5176d71a94ab69ea9fc" trc target="_blank" href="https://www.vegaspreowned.com" class="button primary-button">Visit</a>
										</div>
                                    </div>
								</div>
						</div>
				    </div>
			    </div>


				<!--Illinois Locations -->
			    <div id="illinoislocations-overlay" class="tool-overlay targetOverlay" style="display: none;">
				    <div class="overlay-container">
						<span class="close-overlay"><i class="fa fa-times"></i></span>
						<div class="overlay-content">
							<span class="arrow-animation visible-sm"></span><span class="arrow-animation visible-sm"></span><span class="arrow-animation visible-sm"></span>
							<div class="container-fluid">
                                    <div class="location-box-wrapper">
										<div id="location-box">
											<div class="location-name">
												<h3> Fletcher Jones Audi </h3>
												<span class="address">Sales: 1523 W. North Avenue • Chicago, IL 60642 </span><br />
												<span class="address">Service: 949 N. Elston Ave, Suite 1 • Chicago, IL 60642 </span>

											</div>
											<a trid="0548721564f24007ba93b1" trc target="_blank" href="http://www.fletcherjonesaudi.com" class="button primary-button">Visit</a>
										</div>
										<div id="location-box">
											<div class="location-name">
												<h3> Mercedes-Benz of Chicago </h3>
												<span class="address">Sales: 1520 W. North Avenue • Chicago, IL 60642 </span><br/>
												<span class="address">Service: 949 North Elston Avenue, Suite 2 Chicago, IL 60642</span>
											</div>
											<a trid="b4976d2122494353bec30a" trc target="_blank" href="https://www.mercedesbenzchicago.com/" class="button primary-button">Visit</a>
										</div>


                                        <div id="location-box">
                                            <div class="location-name">
                                                <h3> Sprinter of Chicago </h3>
                                                <span class="address">Sales: 1520 W. North Avenue • Chicago, IL 60642 </span><br/>
                                                <span class="address">Service: 949 North Elston Avenue, Suite 2 Chicago, IL 60642</span>
                                            </div>
                                            <a trid="9bb23a4d153e4bd48e3b31" trc target="_blank" href="https://www.mercedesbenzchicago.com/commercial-vans/" class="button primary-button">Visit</a>
                                        </div>

                                    </div>
								</div>
						</div>
				    </div>
			    </div>
		    </div>
	    </div>

	    <div class="videooverlay-buttons hidden-xs">
		    <div class="button-wrap">
		    	<div class="container-fluid">
			    	<div class="row">
					    <div class="col-sm-2 bottom-ctas">
						    <a trid="d12cb295500040c18b57eb" trc target="hawaiilocations" class="overlay-toggle button primary-button block blue">Hawaii</a>
					    </div>
					    <div class="col-sm-2 bottom-ctas">
							<a trid="c3c4f9431dcd41ce8f4835" trc target="californialocations" class="california overlay-toggle button primary-button block blue">California</a>
						</div>
						<div class="col-sm-2 bottom-ctas">
						    <a trid="5f92b9b64230401ebbfcc5" trc href="/careers/fjmw/" class=" button primary-button block blue">FJ Management</a>
					    </div>
					    <div class="col-sm-2 bottom-ctas">
						    <a trid="bd771b128972410e90af64" trc target="nevadalocations" class="overlay-toggle button primary-button block blue">Nevada</a>
					    </div>
					     <div class="col-sm-2 bottom-ctas">
						    <a trid="84ca7e56064f4f57a1b5ec" trc target="illinoislocations" class="overlay-toggle button primary-button block blue">Illinois</a>
					    </div>
				    </div>
			    </div>
		    </div>
	    </div>
	</div>
	<div class="bottom-text">
		<h3><?php echo get_field("bottom_text");?></h3>
	</div>
</div>
<?php } ?>

<div id="ctaRow-mobile" class="visible-xs">
	<div class="container-wide">
		<div class="row">
			<a trid="1524fda248094e5d92698a" trc class="ctabox" href="/contact/hawaii/" data-gtm-event="mobileCTA1">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctanew-hawaii-location.jpg" alt="Hawaii Locations">
				<h2>Hawaii</h2>
				<span class="ctabox-linktext">Check Dealerships <i class="fa fa-angle-double-right"></i></span>
			</a>
			<a trid="773225985bde49b99638ac" trc class="ctabox" href="/contact/california/" data-gtm-event="mobileCTA2">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctanew-california-location.jpg" alt="California Locations">
				<h2>California</h2>
				<span class="ctabox-linktext">Check Dealerships <i class="fa fa-angle-double-right"></i></span>
			</a>
			<a trid="5945005806d1410fbe4c15" trc class="ctabox" href="/contact/nevada/" data-gtm-event="mobileCTA3">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctanew-nevada-location.jpg" alt="Nevada Locations">
				<h2>Nevada</h2>
				<span class="ctabox-linktext">Check Dealerships <i class="fa fa-angle-double-right"></i></span>
			</a>
			<a trid="716484d7a5d94e6e93ad01" trc class="ctabox" href="/contact/illinois/" data-gtm-event="mobileCTA4">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctanew-chicago-location.jpg" alt="Illinois Locations">
				<h2>Illinois</h2>
				<span class="ctabox-linktext">Check Dealerships <i class="fa fa-angle-double-right"></i></span>
			</a>
			<a trid="be4b56b83730424fabc625" trc class="ctabox" href="/careers/fjmw/" data-gtm-event="mobileCTA4">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/fj-mgmt-west-old-office.jpg" alt="Illinois Locations">
				<h2>FJ Management West</h2>
				<span class="ctabox-linktext">Join Our Team <i class="fa fa-angle-double-right"></i></span>
			</a>
		</div>
	</div>
</div>

<div id="careersRow" class="visible-xs">
	<div class="container-wide">
		<div class="row">
			<div class="col-sm-12">
				<?php the_field('careers_content'); ?>
			</div>
		</div>
	</div>
</div>

<div id="storyRow" class="visible-xs">
	<div class="container-wide">
		<div class="row">
			<div class="col-sm-12">
				<div class="storycontent">
					<?php the_field('story_content');?>
					<img class="visible-xs" src="<?php echo get_stylesheet_directory_uri(); ?>/images/fletcherjones-mobile.png" alt="Fletcher Jones Jr" />
				</div>
			</div>
		</div>
	</div>
</div>

<div style="display:none"><div id="mb">
        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/11/Seagull-Newport-Icon100.png" alt="MB of Chicago" />
            <a trid="7c92a2f349ef43639aaaef" trc href="https://www.fjmercedes.com"><strong><u>Fletcher Jones Motorcars</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            3300 Jamboree Road <br>
            Newport Beach, CA 92660



        </div>


        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/11/Mountains-Ontario-Icon100.png" alt="MB of Chicago" />
            <a trid="2f377358f9fc44baa6bcbe" trc href="https://www.mbontario.com"><strong><u>Mercedes-Benz of Ontario</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            3787 East Guasti Rd <br>
            Ontario, CA 91761

            &nbsp;
        </div>

        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Bridge-FJM-Fremont-Icon-copy.png" alt="MB of Chicago" />
            <a trid="8da95c0e989a4485aeed99" trc href="https://www.mboffremont.com"><strong><u>FJ Motorcars of Fremont</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            5760 Cushing Pkwy <br>
            Fremont, CA 94538


            &nbsp;
        </div>
        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Skyline-MB-Chicago-Icon-copy.png" alt="MB of Chicago" />
            <a trid="09144498c60c432f953298" trc href="https://www.mercedesbenzchicago.com"><strong><u>Mercedes-Benz of Chicago</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            1520 W. North Ave <br>
            Chicago, IL 60642



        </div>

        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Palm-Tree-Honolulu-Icon-copy.png" alt="MB of Chicago" />
            <a trid="8cecde47351b4b35963faf" trc href="https://www.mercedesbenzofhonolulu.com"><strong><u>Mercedes-Benz of Honolulu</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            818 Kapiolani Blvd <br>
            Honolulu, HI 96813


            &nbsp;
        </div>

        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/LV-Sign-FJ-Imports-Icon-copy.png" alt="MB of Chicago" />
            <a trid="097d643b29ba4698ae247c" trc href="https://www.fjimports.com"><strong><u>Fletcher Jones Imports</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            7300 West Sahara Ave <br>
            Las Vegas, NV 89117


            &nbsp;
        </div>

        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Boulders-Henderson-Icon-copy.png" alt="MB of Chicago" />
            <a trid="354239c04c2e4edf9e9cd1" trc href="https://www.mbofhenderson.com"><strong><u>Mercedes-Benz of Henderson</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            925 Auto Show Dr <br>
            Henderson, NV 89014


            &nbsp;
        </div>
        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Wave-Maui-Icon-copy.png" alt="MB of Chicago" />
            <a trid="84a93607630e4e1cb20749" trc href="https://www.mercedesbenzofhonolulu.com"><strong><u>Mercedes-Benz of Maui</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            69 Hobron Ave <br>
            Kahului, HI 96732


            &nbsp;
        </div>

    </div>

</div>


<div style="display:none"><div id="po">
        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Trolley-Porsche-Fremont-Icon-copy.png" alt="MB of Chicago" />
            <a trid="386e2bf3241e4b5f8459b1" trc href="https://www.porscheoffremont.com"><strong><u>Porsche Fremont</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            5740 Cushing Pkwy <br>
            Fremont, CA 94538


            &nbsp;
        </div>

    </div></div>


<div style="display:none"><div id="audi">
        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Skyline-MB-Chicago-Icon-copy.png" alt="MB of Chicago" />
            <a trid="8baa965f00524993aebf81" trc href="https://www.audibeverlyhills.com/"><strong><u>Audi Beverly Hills</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            8850 Wilshire Blvd <br>
            Beverly Hills, CA 90211


            &nbsp;
        </div>

        <div class="single-dealer">
            <img src="https://www.fjautogroup.com/wp-content/plugins/vessel/content/dealers/fletcherjonesautomotivegroup/images/audi-fj-icon.png" alt="MB of Chicago" />
            <a trid="99d432e0b6c74795bef954" trc href="https://www.fletcherjonesaudi.com/"><strong><u>Audi Fletcher Jones</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            1275 Bristol St <br>
            Costa Mesa, CA 92626


            &nbsp;
        </div>

        <div class="single-dealer">
            <img src="https://di-uploads-pod9.dealerinspire.com/fletcherjonesautomotivegroup/uploads/2017/08/Audi-Fremont-Icon-100.png" alt="MB of Chicago" />
            <a trid="d6fe8bc9065841ac9ed68c" trc href="https://www.audifremont.com/"><strong><u>Audi Fremont</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            43191 Boscell Rd <br>
            Fremont, CA 94538


            &nbsp;
        </div>

        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Bean-Chicago-Audi-Icon-copy.png" alt="MB of Chicago" />
            <a trid="01ff56228e54423fba1a20" trc href="https://www.fletcherjonesaudi.com/"><strong><u>Fletcher Jones Audi</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            1523 W. North Ave <br>
            Chicago, IL 60642


            &nbsp;
        </div>


    </div></div>



<div style="display:none"><div id="sprinter">
        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Skyline-MB-Chicago-Icon-copy.png" alt="MB of Chicago" />
            <a trid="fe328e6b24184041bf76c9" trc href="https://www.mercedesbenzchicago.com"><strong><u>Mercedes-Benz of Chicago</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            1520 W. North Ave <br>
            Chicago, IL 60642


            &nbsp;
        </div>

        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Boulders-Henderson-Icon-copy.png" alt="MB of Chicago" />
            <a trid="054a48181af64252b90d23" trc href="https://www.mbofhenderson.com"><strong><u>Mercedes-Benz of Henderson</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            925 Auto Show Dr <br>
            Henderson, NV 89014


            &nbsp;
        </div>
        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/LV-Sign-FJ-Imports-Icon-copy.png" alt="MB of Chicago" />
            <a trid="78da3e97127c40c5add6ab" trc href="https://www.fjimports.com"><strong><u>Fletcher Jones Imports</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            7300 West Sahara Ave <br>
            Las Vegas, NV 89117


            &nbsp;
        </div>
        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Bridge-FJM-Fremont-Icon-copy.png" alt="MB of Chicago" />
            <a trid="9aaf4adf401440e1af327c" trc href="https://www.mboffremont.com"><strong><u>FJ Motorcars of Fremont</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            5760 Cushing Pkwy <br>
            Fremont, CA 94538


            &nbsp;
        </div>

        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Palm-Tree-Honolulu-Icon-copy.png" alt="MB of Chicago" />
            <a trid="27144de5ee5f49da9a5062" trc href="https://www.mercedesbenzofhonolulu.com"><strong><u>Mercedes-Benz of Honolulu</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            818 Kapiolani Blvd <br>
            Honolulu, HI 96813


            &nbsp;
        </div>

        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Wave-Maui-Icon-copy.png" alt="MB of Chicago" />
            <a trid="03728a468a5a493e9cea99" trc href="https://www.mbofmaui.com"><strong><u>Mercedes-Benz of Maui</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            69 Hobron Ave <br>
            Kahului, HI 96732


            &nbsp;
        </div>

    </div></div>


<div style="display:none">
    <div id="honda">
        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Fish-Hilo-Icon-copy.png" alt="MB of Chicago" />
            <a trid="181f28905d8d46e7b3cd84" trc href="https://www.bigislandhonda.com"><strong><u>Big Island <br> Honda-Hilo</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            124 Wiwoole St<br>
            Hilo, HI 96720


            &nbsp;
        </div>
        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Turtle-Kona-Icon-copy.png" alt="MB of Chicago" />
            <a trid="6964eb8ed8964cd181e197" trc href="https://www.bigislandhonda.com"><strong><u>Big Island <br> Honda-Konda</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            75-5608 Kuakini Hwy <br>
            Kailua-Kona, HI 96740


            &nbsp;
        </div>
    </div>
</div>



<div style="display:none">
    <div id="smart">
        <div class="single-dealer">
            <img src="https://di-uploads-development.s3.amazonaws.com/fletcherjonesautomotivegroup/uploads/2016/12/Palm-Tree-Honolulu-Icon-copy.png" alt="MB of Chicago" />
            <a trid="e1a5e200f3dc452cb94439" trc href="https://www.mercedesbenzofhonolulu.com"><strong><u>Mercedes-Benz of Honolulu</u></strong></a><br>
            <span class="mid-bold">Showroom</span><br>
            818 Kapiolani Blvd <br>
            Honolulu, HI 96813


            &nbsp;
        </div>
    </div>
</div>
