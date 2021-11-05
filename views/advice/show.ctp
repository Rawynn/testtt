<div class="advice-page text-page page">
	<div class="page-header">
		<h1>
			<?php echo $advice['Advice']['title'] ?>
		</h1>
	</div>
	
	<div class="page-content cms-content">
		<?php echo $advice['Advice']['content'] ?>
		
		<?php if ($advice['AdviceAttachment']): ?>
			<ul class="tabs nav-justified">
				<li class="active">
					<a href="#do-pobrania" title="<?php echo h(__('Do pobrania', true)) ?>">
						<?php __('Do pobrania') ?>
					</a>
				</li>
			</ul>
			
			<div class="tab-content">
				<div class="tab-pane active" id="do-pobrania">
					<table class="table table-hover">
						<?php foreach ($advice['AdviceAttachment'] as $attachment): ?>
							<tr>
								<td>
									<a href="<?php echo $this->Html->url(getAdviceAttachmentDownloadUrl($attachment['id'])) ?>" target="_blank" title="<?php echo h(sprintf(__('Pobierz "%s"', true),  $attachment['original_filename'])) ?>">
										<strong><?php echo $attachment['original_filename'] ?></strong>
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</table>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>