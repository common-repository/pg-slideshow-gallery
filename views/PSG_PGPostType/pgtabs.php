<?php if ($data instanceof stdClass) : ?>

<nav class="nav-tab-wrapper">
      <a href="#list1" id="pgntlist1" class="nav-tab nav-tab-active" onclick="ShowPGTab('list1');">Content List</a>
      <a href="#settings1" id="pgntsettings1"class="nav-tab <?php if($tab==='settings'):?>nav-tab-active<?php endif; ?>" onclick="ShowPGTab('settings1');">Settings</a>

    </nav>

    <div id="list1" class="PGtab-content PGActiveTab">
	
	
<?php 	echo __CLASS__; PSG_PGMain::outputView('PSG_PGPostType' . DIRECTORY_SEPARATOR . 'slides.php', $data); ?>
    </div>
	
	
	<div id="settings1" class="PGtab-content PGHiddenTab">
<?php 	PSG_PGMain::outputView('PSG_PGPostType' . DIRECTORY_SEPARATOR . 'settings.php', $data); ?>
    </div>
<?php endif; ?>