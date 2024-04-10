<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div>

<h4>A PHP Error was encountered</h4>

<p>Severity: <?php echo html_escape($severity); ?></p>
<p>Message:  <?php echo html_escape($message); ?></p>
<p>Filename: <?php echo html_escape($filepath); ?></p>
<p>Line Number: <?php echo html_escape($line); ?></p>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	<p>Backtrace:</p>
	<?php foreach (debug_backtrace() as $error): ?>

		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

			<p>
			File: <?php echo html_escape($error['file']) ?><br />
			Line: <?php echo html_escape($error['line']) ?><br />
			Function: <?php echo html_escape($error['function']) ?>
			</p>

		<?php endif ?>

	<?php endforeach ?>

<?php endif ?>

</div>