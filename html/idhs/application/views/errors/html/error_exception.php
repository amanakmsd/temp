<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div>

<h4>An uncaught Exception was encountered</h4>

<p>Type: <?php echo html_escape(get_class($exception)); ?></p>
<p>Message: <?php echo html_escape($message); ?></p>
<p>Filename: <?php echo html_escape($exception->getFile()); ?></p>
<p>Line Number: <?php echo html_escape($exception->getLine()); ?></p>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	<p>Backtrace:</p>
	<?php foreach ($exception->getTrace() as $error): ?>

		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

			<p>
			File: <?php echo html_escape($error['file']); ?><br />
			Line: <?php echo html_escape($error['line']); ?><br />
			Function: <?php echo html_escape($error['function']); ?>
			</p>
		<?php endif ?>

	<?php endforeach ?>

<?php endif ?>

</div>