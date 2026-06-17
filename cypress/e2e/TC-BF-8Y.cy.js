describe('TC-BF-8Y', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8Y Nama kosong', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="full_name"]').clear(); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Silahkan input nama anda'); 
    });
});