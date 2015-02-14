using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

namespace CauserieForm
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        public MainWindow()
        {
            InitializeComponent();
        }

        private void Window_Loaded(object sender, RoutedEventArgs e)
        {

        }

        private void comboBox1_SelectionChanged_1(object sender, SelectionChangedEventArgs e)
        {
            if (comboBox1.SelectedIndex == 0)
            {
                RiskAnalysis ra = new RiskAnalysis();
                ra.Show();
                this.Hide();
            }
            if (comboBox1.SelectedIndex == 1)
            {
                PreventionPlan pp = new PreventionPlan();
                pp.Show();
                this.Hide();
            }
            if (comboBox1.SelectedIndex == 2)
            {
                Consignmentcertificate cc = new Consignmentcertificate();
                cc.Show();
                this.Hide();
            }
            if (comboBox1.SelectedIndex == 3)
            {
                HSEQCauserie hc = new HSEQCauserie();
                hc.Show();
                this.Hide();
            }
            if (comboBox1.SelectedIndex == 4)
            {
                Hazardoussituationorincidentrecord hs = new Hazardoussituationorincidentrecord();
                hs.Show();
                this.Hide();
            }
            if (comboBox1.SelectedIndex == 5)
            {
                Securityimprovementaudit si = new Securityimprovementaudit();
                si.Show();
                this.Hide();
            }
            if (comboBox1.SelectedIndex == 6)
            {
                Adequacyandconservationtest ac = new Adequacyandconservationtest();
                ac.Show();
                this.Hide();
            }
            if (comboBox1.SelectedIndex == 7)
            {
                Securitymaterialinventoryandfollow_up sm = new Securitymaterialinventoryandfollow_up();
                sm.Show();
                this.Hide();
            }
            if (comboBox1.SelectedIndex == 8)
            {
                Formtosignatthebeginningoftheproject fb = new Formtosignatthebeginningoftheproject();
                fb.Show();
                this.Hide();
            }
            if (comboBox1.SelectedIndex == 9)
            {
                Accidentsimmediateminutes am = new Accidentsimmediateminutes();
                am.Show();
                this.Hide();
            }


        }
    }
}
