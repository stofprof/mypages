<?php
/**
 * Modern File Browser (Top Right Sort Menu)
 */

// --- Configuration ---
 $hidden_files = ['.', '..', 'index.php', '.git', '.gitignore']; 
 $time_format = 'M j, Y'; 

// --- Helper Functions ---

function getFileIcon($filename, $isDir) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $iconColor = 'var(--icon-color)'; 
    
    $folderIcon = '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 7V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V9C21 7.89543 20.1046 7 19 7H12L10 5H5C3.89543 5 3 5.89543 3 7Z" fill="none" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    $imageIcon = '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 19V5C21 3.89543 20.1046 3 19 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19Z" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="8.5" cy="8.5" r="1.5" fill="'.$iconColor.'"/><path d="M21 15L16 10L5 21" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    $codeIcon = '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 2V8H20" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 13L8 15L10 17" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 13L16 15L14 17" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    $excelIcon = '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 2V8H20" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 13H16" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 17H16" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 9H10" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    $zipIcon = '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 8V19C21 20.1 20.1 21 19 21H5C3.9 21 3 20.1 3 19V5C3 3.9 3.9 3 5 3H16L21 8Z" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 21V13H7V21" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M13 8V3" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    $defaultIcon = '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M13 2V9H20" stroke="'.$iconColor.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

    if ($isDir) return $folderIcon;
    switch ($ext) {
        case 'png': case 'jpg': case 'jpeg': case 'gif': case 'svg': return $imageIcon;
        case 'js': case 'php': case 'html': case 'css': case 'json': return $codeIcon;
        case 'xls': case 'xlsx': case 'csv': return $excelIcon;
        case 'zip': case 'rar': case 'tar': case 'gz': return $zipIcon;
        default: return $defaultIcon;
    }
}

function formatSize($bytes) {
    if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
    if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
    if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
    return $bytes . ' bytes';
}

// Scan Directory
 $files = [];
 $items = scandir(__DIR__);
foreach ($items as $item) {
    if (in_array($item, $hidden_files)) continue;
    $path = __DIR__ . DIRECTORY_SEPARATOR . $item;
    $isDir = is_dir($path);
    $files[] = [
        'name' => $item,
        'type' => $isDir ? 'Folder' : strtoupper(pathinfo($item, PATHINFO_EXTENSION)),
        'size' => $isDir ? '-' : filesize($path),
        'date' => filemtime($path),
        'isDir' => $isDir
    ];
}

// --- Sorting & View Logic ---
 $sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'name';
 $sortOrder = isset($_GET['order']) && $_GET['order'] == 'desc' ? SORT_DESC : SORT_ASC;
 $viewMode = isset($_GET['view']) && $_GET['view'] == 'grid' ? 'grid' : 'list';

usort($files, function ($a, $b) use ($sortColumn, $sortOrder) {
    if ($a['isDir'] !== $b['isDir']) return $a['isDir'] ? -1 : 1;
    $valA = $a[$sortColumn]; $valB = $b[$sortColumn];
    if ($valA == $valB) return 0;
    if ($sortColumn == 'name') return ($sortOrder == SORT_ASC) ? strnatcasecmp($valA, $valB) : strnatcasecmp($valB, $valA);
    return ($sortOrder == SORT_ASC) ? ($valA <=> $valB) : ($valB <=> $valA);
});

 $nextOrder = ($sortOrder == SORT_ASC) ? 'desc' : 'asc';
 $orderParam = ($sortOrder == SORT_ASC) ? 'asc' : 'desc';
 $targetView = ($viewMode == 'list') ? 'grid' : 'list';

// Helper to build URL preserving current params except specific ones
function buildUrl($paramsToUpdate) {
    $query = $_GET;
    foreach ($paramsToUpdate as $key => $value) {
        $query[$key] = $value;
    }
    return '?' . http_build_query($query);
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Browser</title>
    <style>
        :root {
            /* Light Theme */
            --bg-color: #F8FAFC;
            --card-bg: #FFFFFF;
            --text-primary: #1E293B;
            --text-secondary: #64748B;
            --border-color: #E2E8F0;
            --hover-bg: #F1F5F9;
            --primary: #3B82F6;
            --icon-color: #94A3B8;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Dark Theme */
        [data-theme="dark"] {
            --bg-color: #0F172A;
            --card-bg: #1E293B;
            --text-primary: #F1F5F9;
            --text-secondary: #94A3B8;
            --border-color: #334155;
            --hover-bg: #334155;
            --primary: #60A5FA;
            --icon-color: #CBD5E1;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        
        body { background-color: var(--bg-color); color: var(--text-primary); padding: 2rem; min-height: 100vh; }
        
        .container { max-width: 1100px; margin: 0 auto; }

        /* Header */
        header { margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-start; }
        .titles h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-primary); }
        .titles p { color: var(--text-secondary); font-size: 0.9rem; margin-top: 0.25rem; }

        /* Header Actions Group */
        .header-actions { display: flex; gap: 0.75rem; align-items: center; }

        /* Generic Header Button Styling */
        .header-btn {
            background: var(--card-bg); border: 1px solid var(--border-color);
            width: 40px; height: 40px; border-radius: 8px; display: flex;
            align-items: center; justify-content: center; cursor: pointer;
            color: var(--text-secondary); text-decoration: none;
        }
        .header-btn:hover { background: var(--hover-bg); color: var(--primary); border-color: var(--primary); }
        .header-btn svg { width: 20px; height: 20px; display: none; }
        .header-btn .icon-show { display: block; }

        /* Dropdown Menu for Sort Button */
        .dropdown { position: relative; }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: var(--shadow);
            width: 180px;
            z-index: 50;
            padding: 0.5rem 0;
        }
        .dropdown-menu.show { display: block; }
        .dropdown-item {
            display: block;
            padding: 0.75rem 1rem;
            text-decoration: none;
            color: var(--text-primary);
            font-size: 0.9rem;
            transition: background 0.2s;
        }
        .dropdown-item:hover { background-color: var(--hover-bg); color: var(--primary); }

        /* Sort Arrow Styling */
        .sort-arrow {
            padding-left: 0.5rem; margin-left: 0;
            opacity: 0.5;
            font-weight: normal;
        }

        /* Controls Bar */
        .controls {
            background: var(--card-bg); padding: 1rem; border-radius: 12px;
            box-shadow: var(--shadow); display: flex; gap: 1rem; align-items: center;
            margin-bottom: 1.5rem; flex-wrap: wrap;
        }
        .search-box { position: relative; flex: 1; min-width: 200px; }
        .search-box input {
            width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid var(--border-color); border-radius: 8px;
            font-size: 0.95rem; outline: none; background: var(--bg-color); color: var(--text-primary);
        }
        .search-box input:focus { border-color: var(--primary); }
        .search-icon { position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary); width: 18px; height: 18px; }

        /* File Browser Container */
        .file-browser { background: var(--card-bg); border-radius: 12px; box-shadow: var(--shadow); overflow: hidden; }

        /* --- LIST VIEW --- */
        .file-list { list-style: none; }
        .file-list.list { display: block; }
        .file-header {
            display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr;
            padding: 1rem 1.5rem; background-color: var(--hover-bg); border-bottom: 1px solid var(--border-color);
            font-weight: 600; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .sortable { cursor: pointer; user-select: none; display: flex; align-items: center; gap: 0; }
        .sortable:hover { color: var(--text-primary); }
        
        .file-list.list .file-item {
            display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr;
            padding: 1rem 1.5rem; align-items: center; border-bottom: 1px solid var(--border-color);
        }
        .file-list.list .file-item:last-child { border-bottom: none; }
        .file-list.list .file-item:hover { background-color: var(--hover-bg); }
        .file-list.list .col-name { display: flex; align-items: center; gap: 1rem; font-weight: 500; }
        .file-list.list .col-type, .file-list.list .col-size, .file-list.list .col-date { font-size: 0.9rem; color: var(--text-secondary); }
        
        /* --- GRID VIEW --- */
        .file-list.grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
        }
        .file-list.grid .file-header { display: none; }
        .file-list.grid .file-item {
            display: flex; flex-direction: column; align-items: center;
            text-align: center; padding: 2rem 1rem;
            border: 1px solid var(--border-color); border-radius: 12px;
            background: var(--card-bg);
            text-decoration: none; color: inherit;
        }
        .file-list.grid .file-item:hover {
            transform: translateY(-2px); box-shadow: var(--shadow); border-color: var(--primary);
        }
        .file-list.grid .col-name { display: flex; flex-direction: column; align-items: center; gap: 1rem; width: 100%; }
        .file-list.grid .col-name span { font-weight: 500; word-break: break-word; line-height: 1.4; }
        .file-list.grid .col-type, .file-list.grid .col-size, .file-list.grid .col-date { display: none; }

        /* Icons & Links */
        .icon-link {
            width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
            border-radius: 4px; text-decoration: none; flex-shrink: 0;
        }
        .icon-link:hover { background-color: rgba(0,0,0,0.05); }
        [data-theme="dark"] .icon-link:hover { background-color: rgba(255,255,255,0.05); }
        .icon-link svg { width: 28px; height: 28px; display: block; }
        
        .file-list.grid .icon-link { width: 64px; height: 64px; }
        .file-list.grid .icon-link svg { width: 64px; height: 64px; }

        .name-link { color: var(--text-primary); text-decoration: none; }
        .name-link:hover { color: var(--primary); text-decoration: underline; }
        .empty-state { padding: 3rem; text-align: center; color: var(--text-secondary); display: none; }

        @media (max-width: 768px) {
            .file-list.list .file-header { display: none; }
            .file-list.list .file-item { grid-template-columns: 1fr; gap: 0.5rem; padding: 1rem; }
            .file-list.list .col-name { font-size: 1.1rem; }
            .file-list.list .col-type, .file-list.list .col-size, .file-list.list .col-date { font-size: 0.85rem; padding-left: 3.2rem; }
        }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <div class="titles">
                <h1>File Browser</h1>
                <p>Browse your files with style</p>
            </div>

            <div class="header-actions">
                <!-- Theme Toggle Button -->
                <button class="header-btn" id="themeToggle" aria-label="Toggle Theme">
                    <svg class="icon-sun icon-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                    <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                </button>

                <!-- Single View Toggle Button -->
                <a href="<?php echo buildUrl(['view' => $targetView]); ?>" class="header-btn" id="viewToggle" aria-label="Toggle View">
                    <?php if($viewMode == 'list'): ?>
                        <svg class="icon-grid icon-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <svg class="icon-list" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                    <?php else: ?>
                        <svg class="icon-grid" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <svg class="icon-list icon-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                    <?php endif; ?>
                </a>

                <!-- Sort Dropdown Button -->
                <div class="dropdown">
                    <button class="header-btn" id="sortToggle" aria-label="Sort Files">
                        <svg class="icon-sort icon-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="6" x2="20" y2="6"></line><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="18" x2="20" y2="18"></line><path d="M4 6h.01M4 12h.01M4 18h.01"></path></svg>
                    </button>
                    <div class="dropdown-menu" id="sortMenu">
                        <a href="<?php echo buildUrl(['sort'=>'name', 'order'=>$orderParam]); ?>" class="dropdown-item">Sort by Name</a>
                        <a href="<?php echo buildUrl(['sort'=>'date', 'order'=>$orderParam]); ?>" class="dropdown-item">Sort by Date</a>
                        <a href="<?php echo buildUrl(['sort'=>'size', 'order'=>$orderParam]); ?>" class="dropdown-item">Sort by Size</a>
                        <a href="<?php echo buildUrl(['sort'=>'type', 'order'=>$orderParam]); ?>" class="dropdown-item">Sort by Type</a>
                    </div>
                </div>
            </div>
        </header>

        <section class="controls">
            <div class="search-box">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" id="searchInput" placeholder="Search files...">
            </div>
            <!-- Sort dropdown removed from here -->
        </section>

        <div class="file-browser">
            <?php if ($viewMode == 'list'): ?>
            <div class="file-header">
                <div class="col-name sortable" onclick="window.location.href='<?php echo buildUrl(['sort'=>'name', 'order'=>$nextOrder]); ?>'">Name <span class="sort-arrow">&#8645;</span></div>
                <div class="col-type sortable" onclick="window.location.href='<?php echo buildUrl(['sort'=>'type', 'order'=>$nextOrder]); ?>'">Type <span class="sort-arrow">&#8645;</span></div>
                <div class="col-size sortable" onclick="window.location.href='<?php echo buildUrl(['sort'=>'size', 'order'=>$nextOrder]); ?>'">Size <span class="sort-arrow">&#8645;</span></div>
                <div class="col-date sortable" onclick="window.location.href='<?php echo buildUrl(['sort'=>'date', 'order'=>$nextOrder]); ?>'">Modified <span class="sort-arrow">&#8645;</span></div>
            </div>
            <?php endif; ?>

            <ul class="file-list <?php echo $viewMode; ?>" id="fileList">
                <?php if (count($files) > 0): ?>
                    <?php foreach ($files as $file): 
                        $target = $file['isDir'] ? '_self' : '_blank';
                        $iconSvg = getFileIcon($file['name'], $file['isDir']);
                    ?>
                        <li class="file-item" data-name="<?php echo strtolower($file['name']); ?>">
                            <div class="col-name">
                                <a href="<?php echo rawurlencode($file['name']); ?>" target="<?php echo $target; ?>" class="icon-link">
                                    <?php echo $iconSvg; ?>
                                </a>
                                <a href="<?php echo rawurlencode($file['name']); ?>" target="<?php echo $target; ?>" class="name-link">
                                    <?php echo htmlspecialchars($file['name']); ?>
                                </a>
                            </div>
                            <div class="col-type"><?php echo htmlspecialchars($file['type']); ?></div>
                            <div class="col-size"><?php echo ($file['size'] === '-') ? '-' : formatSize($file['size']); ?></div>
                            <div class="col-date"><?php echo date($time_format, $file['date']); ?></div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state" style="display:block;">No files found.</div>
                <?php endif; ?>
            </ul>
            
            <div id="noResults" class="empty-state">No files match your search.</div>
        </div>
    </div>

    <script>
        // --- Search Logic ---
        const searchInput = document.getElementById('searchInput');
        const items = document.querySelectorAll('.file-item');
        const noResults = document.getElementById('noResults');
        
        searchInput.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            let visibleCount = 0;

            items.forEach(item => {
                const name = item.getAttribute('data-name');
                if (name.includes(term)) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (visibleCount === 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        });

        // --- Theme Logic ---
        const themeToggleBtn = document.getElementById('themeToggle');
        const iconSun = themeToggleBtn.querySelector('.icon-sun');
        const iconMoon = themeToggleBtn.querySelector('.icon-moon');
        const htmlElement = document.documentElement;

        function setTheme(theme) {
            htmlElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            if (theme === 'dark') {
                iconMoon.classList.add('icon-show');
                iconSun.classList.remove('icon-show');
            } else {
                iconSun.classList.add('icon-show');
                iconMoon.classList.remove('icon-show');
            }
        }

        const savedTheme = localStorage.getItem('theme') || 'light';
        setTheme(savedTheme);

        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
        });

        // --- Sort Menu Logic ---
        const sortToggleBtn = document.getElementById('sortToggle');
        const sortMenu = document.getElementById('sortMenu');

        sortToggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sortMenu.classList.toggle('show');
        });

        // Close menu when clicking elsewhere
        window.addEventListener('click', () => {
            sortMenu.classList.remove('show');
        });
    </script>
</body>
</html>