							<form action="site.php?category=2&id=1&sendt" method="POST">
							<fieldset><legend>Søknad om plass på Blindern Studenterhjem</legend>
								<h2>Personalia:</h2>
								<div class="soknadskjema">
									<label for="navn">Navn: </label>
									<input type=text name="navn" id="name" value="%s">*
								</div>
								<div class="soknadskjema">
									<label for="Kjønn">Kjønn: </label>
									<select name="kjonn" id="kjonn">
											<option value="Mann" %s>Mann
											<option value="Kvinne" %s>Kvinne
									</select>*
								</div>
								<div class="soknadskjema">
									<label for="personnummer">Personnummer</label>
									<input type="text" name="personnummer" id="fodt" value="%s">*
								</div>
								<div class="soknadskjema">
									<label for="mob">Mobiltelefonnr:</label>
									<input type="text" name="mob" id="mob" value="%s">
								</div>
								<div class="soknadskjema">
									<label for="tlf">Evt Fasttelefon:</label>
									<input type="text" name="tlf" id="tlf" value="%s">
								</div>
								<div class="soknadskjema">
									<label for="epost">E-post:</label>
									<input type="text" name="epost" id="epost" value="%s">*
								</div>
								<div class="soknadskjema">
									<label for="studiested">Studiested:</label>
									<input type="text" name="studiested" id="studiested" value="%s">*
								</div>
								<div class="soknadskjema">
									<label for="studium">Studium:</label>
									<input type="text" name="studium" id="studium" value="%s">*
								</div>
								<h2>N&aring;v&aelig;rende Bosted</h2>
								<div class="soknadskjema">
									<label for="addr">Adresse:</label>
									<input type="text" name="addr" id="addr" value="%s">
								</div>
								<div class="soknadskjema">
									<label for="postnr">Postnummer og sted:</label>
									<input type="text" name="postnr" id="postnr" value="%s">
								</div>
								<h2>Opprinnelig bosted (Hjemstedsadresse):</h2>
								<div class="soknadskjema">
									<label for="hjemaddr">Adresse:</label>
									<input type="text" name="hjemaddr" id="hjemaddr" value="%s">
								</div>
								<div class="soknadskjema">
									<label for="hjempostnr">Postnummer og sted:</label>
									<input type="text" name="hjempostnr" id="hjempostnr" value="%s">
								</div>
								<h2>Om søknaden:</h2>
								<div class="soknadskjema">
									<label for="onsketdato">&Oslash;nsket innflyttningsdato:</label>
									<input type="text" name="onsketdato" id="onsketdato" value="%s">*
								</div>
								<div class="soknadskjema">
									<label for="antMnd">
									<div class="formText">
										Dersom du ikke får plass ved hjemmet til den
										datoen du ønsker, hvor mange måender vil
										du at søknaden skal gjelde etter denne
										datoen?
									</div>
									</label>
									<select name="antMnd" id="antMnd">
											<option value="1" %s>01
											<option value="2" %s>02
											<option value="3" %s>03
											<option value="4" %s>04
											<option value="5" %s>05
											<option value="6" %s>06
									</select>
								</div>

								<div class="soknadskjema">
									<label for="omperson">
									<p>
										Skriv en beskrivelse av deg selv og dine
										interesser. Dette kreves for at din søknad
										skal tas i betraktning. Skriv ogs&aring; navn på
										tidligere beboere eller n&aring;v&aelig;rende beboere
										dersom du ønsker/har referanser. Se tekst
										om hva som legges vekt på ved søknad her.
									</p>
									</label>
									<textarea name="omperson" cols=40 rows=8 id="omperson">%s</textarea>*
								</div>

								<div class="soknadskjema">
									<label for="kommentar">
									<p>
										Kommentarer eller &oslash;vrige opplysninger:
									</p>
									</label>
									<textarea name="kommentar" cols=40 rows=5 class='text_contact' id="kommentar">%s</textarea>
								</div>
								<div class="soknadskjema">
									<input type="submit" value="Send" class="knapp" name="submit">
								</div>
							</fieldset>