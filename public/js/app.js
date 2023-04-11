import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();

function testEthereumConnection() {
    const Web3 = require('web3');
    const web3 = new Web3('https://dry-frequent-grass.ethereum-goerli.quiknode.pro/');

    web3.eth.getBlock('latest').then(answer => console.log(answer));
    web3.eth.getBlockNumber().then(blockNum => console.log(blockNum));
}