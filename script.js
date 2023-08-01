const btnCustomer = document.getElementById('btn-customer');
const btnExecutor = document.getElementById('btn-executor');
const customerDiv = document.getElementById('customerDiv');
const executorDiv = document.getElementById('executorDiv');

btnCustomer.addEventListener('click', () => {
    customerDiv.style.display = 'block';
    executorDiv.style.display = 'none';
});

btnExecutor.addEventListener('click', () => {
    customerDiv.style.display = 'none';
    executorDiv.style.display = 'block';
});

