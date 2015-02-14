using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using PdfSharp.Pdf;
using PdfSharp.Drawing;
using PdfSharp.Drawing.Pdf;
using PdfSharp.Drawing.Layout;
using PdfSharp.Drawing.BarCodes;
using System.Diagnostics;
using MigraDoc.DocumentObjectModel;
using MigraDoc.DocumentObjectModel.Tables;
using MigraDoc.DocumentObjectModel.Shapes;
using MigraDoc.Rendering.Forms;
using MigraDoc.DocumentObjectModel.Fields;
using MigraDoc.Rendering;

namespace Accident_Immediate
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            PdfDocument pdf = new PdfDocument();
            PdfPage pg = pdf.AddPage();
            XGraphics xg = XGraphics.FromPdfPage(pg);
            XFont ft = new XFont("Microsoft Sans Serif", 13, XFontStyle.Bold);
            XFont fnt = new XFont("Microsoft Sans Serif", 12, XFontStyle.Regular);
            XPen pen = new XPen(XColors.LimeGreen, 1);
            XPen pe = new XPen(XColors.Black,1);
            xg.DrawRoundedRectangle(pen, 80, 33, 450, 40, 20, 30);
            xg.DrawString("COMPTE RENDU D'ACCIDENT A CHAUD", ft, XBrushes.Black, new XRect(20, 45, pg.Width.Point, pg.Height.Point), XStringFormats.TopCenter);
            xg.DrawString("Partie remplie par le responsable hiérarchique du blessé, transmise au service médical ainsi qu'au", fnt, XBrushes.Black, new XRect(20, 80, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("responsable SSE dans les 24 heures", fnt, XBrushes.Black, new XRect(20, 100, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawRectangle(pe, 20, 120, 558, 55);
            xg.DrawString("Employeur : "+textBox1.Text, fnt, XBrushes.Black, new XRect(40, 125, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("N°, Rue, BP : " + textBox2.Text, fnt, XBrushes.Black, new XRect(300, 125, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Code postal : " + textBox3.Text, fnt, XBrushes.Black, new XRect(40, 150, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Commune : " + textBox4.Text, fnt, XBrushes.Black, new XRect(300, 150, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawRectangle(pe, 20, 185, 558, 60);
            xg.DrawRectangle(pe, 20, 185, 558, 20);
            xg.DrawString("ACCIDENTE", ft, XBrushes.Black, new XRect(250, 188, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Fonction : "+textBox5.Text, fnt, XBrushes.Black, new XRect(40, 208, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Qualification : " + textBox6.Text, fnt, XBrushes.Black, new XRect(300, 208, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Ancienneté au poste : " + textBox7.Text, fnt, XBrushes.Black, new XRect(40, 228, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            string msg = "";
            if (checkBox3.Checked == true)
            {
                msg = "M";
            }
            if (checkBox4.Checked == true)
            {
                msg = "B";
            }
            if (checkBox5.Checked == true)
            {
                msg = "TB";
            }
            //if (msg.Length > 0)
            //{
                
            //}
            //else
            //{
            //    MessageBox.Show ("No checkbox selected");
            //}

            checkBox3.ThreeState = true;
            xg.DrawString("Connaissance du poste : " + msg, fnt, XBrushes.Black, new XRect(300, 228, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawRectangle(pe, 20, 255, 558, 560);
            
            xg.DrawString("Accidente:Jour de l'accident : "+textBox8.Text, fnt, XBrushes.Black, new XRect(23, 260, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            string shortDate = dateTimePicker1.Value.ToShortDateString();
            xg.DrawString("Date : " + shortDate, fnt, XBrushes.Black, new XRect(300, 260, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            string dtacc = "";
            if (checkBox6.Checked == true)
            {
                dtacc = "Lieu habituel chantier";
            }
            if (checkBox7.Checked == true)
            {
                dtacc = "Bureau";
            }
            if (checkBox8.Checked == true)
            {
                dtacc = "Atelier";
            }
            if (checkBox9.Checked == true)
            {
                dtacc = "Occasionnel";
            }
            checkBox6.ThreeState = true;
            xg.DrawString("Lieu de l'accident : " + dtacc, fnt, XBrushes.Black, new XRect(23, 280, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            string cbox = "";
            cbox = cmb1.GetItemText(cmb1.SelectedItem);
            xg.DrawString("Au moment de l'accident,la victime exerçait-elle une occupation dans le cadre de sa", fnt, XBrushes.Black, new XRect(23, 300, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("fonction habituelle?: " + cbox, fnt, XBrushes.Black, new XRect(23, 320, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Si non, quelle occupation exerçait-elle ?", fnt, XBrushes.Black, new XRect(23, 340, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("LIEU EXACT DE L'ACCIDENT", fnt, XBrushes.Black, new XRect(23, 360, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("N°, Rue, BP : "+textBox9.Text, fnt, XBrushes.Black, new XRect(23, 380, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Code postal : " + textBox10.Text, fnt, XBrushes.Black, new XRect(200, 380, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Commune  : " + textBox11.Text, fnt, XBrushes.Black, new XRect(380, 380, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            //xg.DrawRectangle(pe, 20, 255, 558, 20);
            xg.DrawString("CIRCONSTANCES DETAILLEES DE L'ACCIDENT" + textBox11.Text, fnt, XBrushes.Black, new XRect(23, 400, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Témoin immédiat(Nom Prénom,Personne ayant assisté visuellement à l'accident) : " + textBox12.Text, fnt, XBrushes.Black, new XRect(23, 420, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Première personne ayant été informée de l'accident : " + textBox13.Text, fnt, XBrushes.Black, new XRect(23, 440, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Précisez l'activité générale (type de travail) qu'effectuait la victime ou la tâche : " + textBox14.Text, fnt, XBrushes.Black, new XRect(23, 460, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Blessures constatées ", ft, XBrushes.Black, new XRect(23, 480, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Siège des lésions : "+textBox15.Text, fnt, XBrushes.Black, new XRect(23, 500, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Nature des lésions : " + textBox16.Text, fnt, XBrushes.Black, new XRect(23, 520, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Détails et circonstances de l'accident" + textBox16.Text, ft, XBrushes.Black, new XRect(23, 540, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Indiquez ce que faisait la victime au moment de l'accident (injection électrique, manutention,…) et", fnt, XBrushes.Black, new XRect(23, 560, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("comment celui-ci s'est produit (glissade, heurt,….)", fnt, XBrushes.Black, new XRect(23, 580, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("comment celui-ci s'est produit (glissade, heurt,….)", fnt, XBrushes.Black, new XRect(23, 580, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Comment la victime a-t-elle été blessée (lésion physique ou psychique),  précisez chaque fois par", fnt, XBrushes.Black, new XRect(23, 600, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("ordre d'importance tous les différents contacts qui ont provoqué la (les) blessure(s)", fnt, XBrushes.Black, new XRect(23, 620, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            XFont tf = new XFont("Microsoft Sans Serif", 10,XFontStyle.Regular);
            xg.DrawString("(ex. contact avec une source de chaleur ou des substances dangereuses, écrasement contre un objet ou heurt par un objet,", tf, XBrushes.Black, new XRect(23, 635, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("collision,contact avec un objet coupant ou pointu,coincement ou écrasement par un objet,problèmes d'appareil locomoteur,", tf, XBrushes.Black, new XRect(23, 645, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("choc mental, blessure causée par un animal ou par une personne, etc.) et les objets impliqués", tf, XBrushes.Black, new XRect(23, 655, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Quels événements déviant par rapport au processus normal du travail ont provoqué l'accident ", fnt, XBrushes.Black, new XRect(23, 675, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);
            xg.DrawString("Quels événements déviant par rapport au processus normal du travail ont provoqué l'accident ", fnt, XBrushes.Black, new XRect(23, 675, pg.Width.Point, pg.Height.Point), XStringFormats.TopLeft);









            string pdffilename = "Accident Immediate Minutes Tool";
            pdf.Save(pdffilename);
            Process.Start(pdffilename);
        }
    }
}
