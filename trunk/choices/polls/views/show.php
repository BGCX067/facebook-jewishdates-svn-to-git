<?		if(isset($rec)){								?>
			<h1><?=$rec->data['title']?></h1>
			<h2><?=$rec->data['notes']?></h2>
<?			foreach ($rec->getQuestions() as $question) {	?>
				<div class="question">
					<div class="questionTitle">
						<?=$question->data['title']?>
					</div>
					<div class="choices">
						<label class="label1" for="<?=$question->data['question_id']?>1">Won't Work</label>
						<input type="radio" value="-1" name="<?=$question->data['id']?>" id="<?=$question->data['id']?>1"/>
						<label class="label2" for="<?=$question->data['id']?>2">Kinda</label>
						<input type="radio" value="0" name="<?=$question->data['id']?>" id="<?=$question->data['id']?>2"/>
						<label class="label3" for="<?=$question->data['id']?>3">Works Great!</label>
						<input type="radio" value="1" name="<?=$question->data['id']?>" id="<?=$question->data['id']?>3"/>
					</div>
				</div>
<?			}											?>
<? 		}else{ 											?>
			<h1>Sorry the page you requested does not exist</h1>
<?		}												?>