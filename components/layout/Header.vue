<template>
    <div id="header" class="fixed bg-white w-full shadow px-90 flex justify-between items-center">
<!--        <a href="/">-->
<!--            <img :src="require('~/assets/img/1.png')" class="h-15 w-15 block" />-->
<!--        </a>-->
        <div id="menu" class="flex gap-16 uppercase items-center text-5 xl:text-4 tracking-wide">
            <div v-for="(link, i) in links" :key="i" class="relative group p-4 text-center">
                <a :href="link.link" class="hover:text-pq-orange transition-colors duration-300"> {{ link.label }} </a>
                <div
                    v-if="link.sublinks"
                    class="absolute hidden gap-4 top-full bg-white w-full text-center group-hover:grid left-0"
                >
                    <a
                        v-for="(sublink, j) in link.sublinks"
                        :key="j"
                        :href="sublink.link"
                        class="hover:text-pq-orange transition-colors duration-300"
                    >
                        {{ sublink.label }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            links: [
                {
                    label: 'Zacznij tutaj',
                    link: 'http://google.com',
                    sublinks: [
                        { label: 'O mnie', link: 'https://psychologiczneiq.pl/zacznij-tutaj/#omnie' },
                        { label: 'Kontakt', link: 'http://google.com' },
                    ],
                },
                { label: 'Psychoteka', link: 'http://google.com' },
                { label: 'Strefa Wiedzy', link: 'http://google.com' },
                { label: 'Z mojej perspektywy', link: 'http://google.com' },
            ],
        }
    },
}
</script>

<style scoped></style>
