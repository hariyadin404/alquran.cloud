<?php require_once('common/header.php'); ?>
<?php require_once('common/navigation.php'); ?>
<?php // ================================================================ // ?>
<?php use AlQuranCloud\Renderer\Ayah; ?>
<?php use AlQuranCloud\Renderer\Generic; ?>
<?php use AlQuranCloud\Renderer\Quran; ?>

<div class="container">

	<?php foreach ($quran->data->surahs as $key => $surah) {
		$hideThisSurah = $surah->number != 1 ? 'hide' : ''; ?>
		<div class="<?=$hideThisSurah; ?> displayedSurah<?= $surah->number; ?>">';
			<?= Quran::renderSurahHeaderRow($surah); ?>
			<hr />
			<?php if ($surah->number != 9) { ?>
			<div class="lead font-mequran2 align-center style-ayah">
				بِسْمِ ٱللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
			</div>
			<?php } ?>
			<?php $ayahs = (array) $surah->ayahs;
			if (isset($quranEdition)) {
				$ayahEditions = (array) $quranEdition->data->surahs[$key]->ayahs;
			} ?>
			<div class="row">
				<div class="col-md-12" style="padding: 0 30px 0 30px">
					<?php
					if (!isset($quranEdition)) {
						echo Quran::renderAyahs($surah, $ayahs);
					} else {
						echo Quran::renderAyahs($surah, $ayahs, $quranEdition, $ayahEditions);
					}
					?>
				</div>
			</div>
			<hr />
		</div>
	<?php } ?>

</div>

<div class="playerBar" style="bottom: 0; margin-bottom: 60px; position: fixed; width: 100%; z-index: 1000;">
<div class="container">
<div class="row" id="surahConfigurator" style="padding: 10px 7% 0 7%;">
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
		<form>
			<div class="form-group">
				<select id="surahSelector" name="surahSelector" title="Select Surah" class="form-control" >
					<?php foreach ($suwar->data as $ss) { ?>
					<option value="<?= $ss->number; ?>" <?= $ss->number == 1 ? 'selected="selected"' : ''; ?>><?= $ss->name; ?> (<?= $ss->englishName; ?>)</option>
					<?php } ?>
				</select>
			</div>
		</form>
	</div>
	<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
		<form class="align-center">
			<div class="form-group">
				<label for="editionSelector">Show translation </label>
				<select id="editionSelector" name="editionSelector" multiple="multiple" title="Select Language" class="form-control" >
					<?php foreach (Generic::getEditionsByLanguage($editions['editions']->data) as  $language => $edition) { ?>
					<optgroup label="<?= $language; ?>">
						<?php foreach ($edition as $e) { ?>
							<option value="<?= $e->identifier; ?>" <?= isset($quranEdition) && $quranEdition->data->edition->identifier == $e->identifier ? 'selected="selected"' : ''; ?>><?= $e->name; ?></option>
						<?php } ?>
					</optgroup>
					<?php } ?>
				</select>
			</div>
		</form>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	<audio id="quranPlayer" controls="controls" class="align-right rt">
		<?php foreach ($quran->data->surahs as $surah) { ?>
			<?php if ($surah->number > 1 && $surah->number != 9) { ?>
			<source src="//cdn.alquran.cloud/media/audio/ayah/ar.alafasy/1/high" title="Bismillah" type="audio/mp3"/>
			<?php } ?>
			<?php foreach ($surah->ayahs as $ayah) { ?>
			<source src="//cdn.alquran.cloud/media/audio/ayah/ar.alafasy/<?= $ayah->number; ?>/high" title="<?= $surah->number; ?>_<?= $ayah->numberInSurah; ?>" type="audio/mp3"/>
			<?php } ?>
		<?php } ?>
	</audio>
	</div>
</div>
</div>
</div>

<script src="//cdn.alquran.cloud/public/libraries/mediaelementjs-2.21.2/build/mediaelement-and-player.js"></script>
<script src="//cdn.alquran.cloud/public/libraries/mep-feature-playlist/mep-feature-playlist.js"></script>
<script src="//cdn.alquran.cloud/public/js/jquery.mediaplayer.js"></script>
<script src="//cdn.alquran.cloud/public/js/jquery.quran.js"></script>
<script>
$(function() {
	var player = $.alQuranMediaPlayer.getQuranPlayer('#quranPlayer');
	$('#editionSelector').multiselect({ enableFiltering: true, enableCaseInsensitiveFiltering: true, dropUp: true, maxHeight: 400 });
	$.alQuranQuran.editions('#editionSelector');
	$.alQuranQuran.surahs('#surahSelector', player);
	$.alQuranQuran.playThisAyah(player);
	$.alQuranQuran.zoomIntoThisAyah();

});
</script>



<?php // ================================================================ // ?>
<?php require_once('common/footer.php'); ?>
