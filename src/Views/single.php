<?php
/**
 * @see TaskSingleController::render()
 *
 * @var TaskEntity|null $task
 * @var bool            $editing
 */

echo get_header( [ 'title' => $task->getTitle() ] );
?>
<main class="container mx-auto">
  <header class="flex flex-row mt-8 items-center mb-8">
    <h1 class="text-2xl font-bold uppercase tracking-widest">
      Créer/Modifier une tâche
    </h1>
  </header>
  
  <form method="post" class="flex-1 flex flex-col space-y-4">
    
    <!-- Name -->
    <label class="select-none">
      <span class="text-xs uppercase text-slate-400 font-bold">Nom</span>
      <input
        type="text"
        placeholder="Nom..."
        value="<?=$task->getTitle()?>"
        name="name"
        class="appearance-none block w-full bg-slate-100 text-slate-700 border border-slate-100 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-slate-400"
      />
    </label>
    
    <!-- Content -->
    <label class="select-none">
      <span class="text-xs uppercase text-slate-400 font-bold">Description</span>
      <textarea 
      name="content" 
      placeholder="Contenu..."
      class="appearance-none block w-full bg-slate-100 text-slate-700 border border-slate-100 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-slate-400 min-h-[200px]"><?=$task->getDescription()?></textarea>
    </label>
    
    <!-- completed -->
    <div class="pt-2">
      <label class="inline-flex relative items-center cursor-pointer">
        <input type="checkbox" name="completed" class="sr-only peer" <?php if ($task->isCompleted()) {echo "checked";} ?>>
        <span class="w-11 h-6 bg-slate-100 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-teal-400"></span>
        <span class="ml-3 text-sm font-medium text-slate-400 select-none cursor pointer">Terminée</span>
      </label>
    </div>
    
    <input type="hidden" name="id" value="<?=$task->getId()?>"/>
    
    <div class="flex flex-row space-x-4 pt-2">
      <button type="submit" name="action" value="save" class="p-4 rounded bg-teal-400 hover:bg-teal-500 duration-300 transition-colors flex items-center font-medium text-sm uppercase text-white tracking-widest flex-1 justify-center">
        Créer/Modifier
      </button>
      
    </div>
  </form>
</main>
<?php echo get_footer(); ?>
