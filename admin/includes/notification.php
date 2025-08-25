<!-- Message de notification -->
<div id="notification" class="hidden fixed bottom-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300">
    <div class="flex items-center">
        <i id="notificationIcon" class="mr-2"></i>
        <span id="notificationMessage"></span>
    </div>
</div>

<style>
    /* Styles pour la notification */
    #notification {
        transform: translateX(100%);
        transition: transform 0.3s ease;
    }
</style>