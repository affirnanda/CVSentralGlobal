describe('TC-BF-8X', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8X Nama >100 karakter ditolak', () => {
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="full_name"]').clear().type('A'.repeat(101)); 
        cy.get('button[type="submit"]').click(); 
        cy.contains(/terlalu panjang/i); });
});