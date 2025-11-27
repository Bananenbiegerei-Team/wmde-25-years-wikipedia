<div class="overflow-hidden rounded-lg bg-secondary aspect-h-9 aspect-w-16">
    <div class="absolute inset-0 w-full h-full">
        <div class="z-20 relative -translate-x-[2.5%] w-[105%] h-[109%] -translate-y-[9%]">
            <template x-for="(row, rowIndex) in rows" :key="rowIndex">
                <div class="flex" :style="`transform: translateY(calc(-${rowIndex} * 20.2%))`">
                    <template x-for="(piece, colIndex) in row" :key="colIndex">
                        <img class="w-[12.3%] max-w-auto transition-opacity duration-300 h-auto"
                            style="filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));"
                            :class="{ 'opacity-0': piece.revealed, 'opacity-100': !piece.revealed }"
                            :style="`transform: translateX(calc(-${colIndex} * 20.3%)) translateY(${colIndex % 2 === 1 ? '19.8%' : '0%'}) rotate(${colIndex % 2 === 1 ? -90 : 0}deg)`"
                            @mouseenter="revealPiece(rowIndex, colIndex)"
                            src="<?php echo get_template_directory_uri(); ?>/blocks/w25-bus/puzzle.svg"
                            alt="Puzzle piece">
                    </template>
                </div>
            </template>
        </div>
        <img class="z-10 absolute w-[800px] h-auto bottom-[0px] transition-transform duration-[1000ms] ease-linear"
            :style="`transform: translateX(${allPuzzlesRevealed ? '-300%' : '0%'}) translateY(${allPuzzlesRevealed ? '-20%' : '0%'}) scale(${allPuzzlesRevealed ? '2' : '1'}); right: -100px;`"
            src="<?php echo get_template_directory_uri(); ?>/blocks/w25-bus/bus.png" alt="Wikipedia Bus">
        <p class="leading-none text-6xl font-headings z-10 absolute top-[60px] left-[60px]"
            :class="allPuzzlesRevealed ? 'animate-bounce' : 'opacity-0'">
            Wir freuen <br>uns auf euch!
        </p>
    </div>
</div>