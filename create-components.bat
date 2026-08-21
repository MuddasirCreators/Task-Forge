@echo off

mkdir resources\views\components 2>nul

echo Creating Breeze components...


(
echo ^<button
echo     {{ $attributes->merge([
echo         'type'^=>'submit',
echo         'class'^=>'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500'
echo     ]) }}
echo ^>
echo     {{ $slot }}
echo ^</button^>
) > resources\views\components\danger-button.blade.php


(
echo ^<button
echo     {{ $attributes->merge([
echo         'type'^=>'button',
echo         'class'^=>'inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest'
echo     ]) }}
echo ^>
echo     {{ $slot }}
echo ^</button^>
) > resources\views\components\secondary-button.blade.php


(
echo @props(['active'^=>false])
echo.
echo ^<a {{ $attributes->merge(['class'^=>'block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100']) }}^>
echo     {{ $slot }}
echo ^</a^>
) > resources\views\components\dropdown-link.blade.php


(
echo ^<input
echo     type="checkbox"
echo     {{ $attributes->merge(['class'^=>'rounded border-gray-300 text-indigo-600 shadow-sm']) }}
echo ^>
) > resources\views\components\checkbox.blade.php


(
echo @props(['id'^=>'modal'])
echo.
echo ^<div id="{{ $id }}" class="hidden fixed inset-0 z-50"^>
echo     ^<div class="bg-white rounded-lg shadow-xl p-6"^>
echo         {{ $slot }}
echo     ^</div^>
echo ^</div^>
) > resources\views\components\confirmation-modal.blade.php


(
echo @props(['show'^=>false])
echo.
echo ^<div x-data="{show:@js($show)}" x-show="show" class="fixed inset-0 z-50"^>
echo     ^<div class="fixed inset-0 bg-gray-500 opacity-75"^>^</div^>
echo     ^<div class="bg-white rounded-lg shadow-xl p-6 max-w-2xl mx-auto mt-20"^>
echo         {{ $slot }}
echo     ^</div^>
echo ^</div^>
) > resources\views\components\modal.blade.php


echo Completed.
pause