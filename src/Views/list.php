<?php
echo get_header( [ 'title' => 'Accueil' ] );
/**
 * @var TaskEntity[] $tasks
 */
?>
  <div class="container mx-auto flex flex-row items-stretch space-x-8">
    <!-- Filters -->
    <aside class="block w-1/4 mt-[7.1rem]">
      <?= get_template( __PROJECT_ROOT__ . "/Views/fragments/filter-form.php", [
        // TODO y aura sûrement un truc à faire ici 🤔
      ] ); ?>
    </aside>
    <!-- /Filters -->
    
    <main class="container mx-auto flex-1">
      <!-- Header + Search Form -->
      <header class="flex flex-row mt-8 items-center justify-space-between  mb-8">
        <h1 class="text-2xl font-bold uppercase tracking-widest flex-1">
          Tâches
        </h1>
        
        <a class="p-4 rounded bg-teal-400 hover:bg-teal-500 duration-300 transition-colors flex items-center font-medium text-sm uppercase text-white tracking-widest justify-center" href="/task">
          Créer <i class="iconoir-add-circled-outline block ml-2 text-xl"></i>
        </a>
      </header>
      <!-- /Header + Search Form -->
      
      <form method="post">
        
        <!-- Task -->
        <?php

        $date;
        for ($i = ($tasks['page']-1)*$tasks['perPage'] ; $i < $tasks['page']*$tasks['perPage'] ; $i++ ) {
          if (isset($tasks['tasks'][$i])) {
            $task = $tasks['tasks'][$i];
            if (!isset($date) || $date !== date('d/m/Y',strtotime($task->getCreatedAt()))) {
              $date = date('d/m/Y',strtotime($task->getCreatedAt()));
              echo '<strong>'.  $date .'</strong>';
            }
            echo get_template( __PROJECT_ROOT__ . "/Views/fragments/task.php", [
              'task' => $task,
            ] );
          }
        }

        ?>
        
        <!-- Pagination + Submit -->
        <div class="flex flex-row justify-space-between items-center">
          <!-- Submit -->
          <button type="submit" class="p-4 rounded bg-teal-400 hover:bg-teal-500 duration-300 transition-colors flex items-center font-medium text-sm uppercase text-white tracking-widest justify-center">
            Enregistrer <i class="iconoir-save-floppy-disk block ml-2 text-xl"></i>
          </button>
          
          <!-- Pagination -->
          <div class="flex-1 flex flex-row justify-end space-x-4 my-8">
            <?php for ($i = 1; $i <= ceil($tasks['total']/$tasks['perPage']); $i++) { ?>
              <a href=<?= "http://$_SERVER[HTTP_HOST]?".http_build_query(array_merge($_GET, ['page' => $i])) ?> class="block bg-slate-50 hover:bg-slate-200 rounded p-4 text-sm cursor-pointer transition-colors duration-300">
                <?= $i ?>
              </a>
            <?php } ?>
          </div>
        </div>
        <!-- /Pagination -->
      </form>
    </main>
  </div>
<?php echo get_footer(); ?>